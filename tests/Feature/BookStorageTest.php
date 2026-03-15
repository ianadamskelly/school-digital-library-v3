<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Category;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookStorageTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_uploads_book_pdf_and_cover_image_to_local_public_storage(): void
    {
        Storage::fake('public');

        $teacher = User::factory()->create([
            'role' => 'teacher',
        ]);

        $category = Category::query()->create([
            'name' => 'Story Books',
        ]);

        $grade = Grade::query()->create([
            'name' => 'Grade 4',
        ]);

        $pdfFile = $this->makePdfUpload('storybook.pdf');
        $coverImage = UploadedFile::fake()->image('cover.jpg');

        $response = $this->actingAs($teacher)
            ->from(route('books.create'))
            ->post(route('books.store'), [
                'title' => 'The Fast River',
                'author' => 'A. Writer',
                'category_id' => $category->id,
                'grades' => [$grade->id],
                'pdf_file' => $pdfFile,
                'cover_image' => $coverImage,
            ]);

        $response->assertRedirect(route('teacher.dashboard'));
        $response->assertSessionHas('success', 'Book uploaded successfully!');

        $book = Book::query()->firstOrFail();

        $this->assertNotNull($book->google_drive_id);
        $this->assertNotNull($book->cover_image);
        $this->assertSame(1, $book->total_pages);

        Storage::disk('public')->assertExists($book->google_drive_id);
        Storage::disk('public')->assertExists($book->cover_image);
        $this->assertDatabaseHas('book_grade', [
            'book_id' => $book->id,
            'grade_id' => $grade->id,
        ]);
    }

    public function test_student_streams_book_pdf_from_local_public_storage(): void
    {
        Storage::fake('public');

        $student = User::factory()->create([
            'role' => 'student',
        ]);

        $book = Book::query()->create([
            'title' => 'Slow Network Book',
            'author' => 'A. Writer',
            'google_drive_id' => 'books/pdfs/slow-network-book.pdf',
            'total_pages' => 1,
        ]);

        Storage::disk('public')->put($book->google_drive_id, $this->minimalPdfContent());

        $response = $this->actingAs($student)->get(route('books.stream', $book));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_teacher_can_open_the_add_book_page(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
        ]);

        $response = $this->actingAs($teacher)->get(route('books.create'));

        $response->assertOk();
        $response->assertSee('Add a New Book');
        $response->assertSee('Add to Library');
    }

    public function test_failed_book_upload_redirects_back_to_the_add_book_page_with_errors(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
        ]);

        $response = $this->actingAs($teacher)
            ->from(route('books.create'))
            ->post(route('books.store'), []);

        $response->assertRedirect(route('books.create'));
        $response->assertSessionHasErrors([
            'title',
            'author',
            'category_id',
            'grades',
            'pdf_file',
        ]);
    }

    private function makePdfUpload(string $originalName): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'pdf');
        file_put_contents($path, $this->minimalPdfContent());

        return new UploadedFile(
            $path,
            $originalName,
            'application/pdf',
            null,
            true
        );
    }

    private function minimalPdfContent(): string
    {
        $objects = [
            '1 0 obj<< /Type /Catalog /Pages 2 0 R >>endobj',
            '2 0 obj<< /Type /Pages /Kids [3 0 R] /Count 1 >>endobj',
            '3 0 obj<< /Type /Page /Parent 2 0 R /MediaBox [0 0 300 144] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>endobj',
            "4 0 obj<< /Length 44 >>stream\nBT\n/F1 24 Tf\n72 96 Td\n(Local PDF) Tj\nET\nendstream\nendobj",
            '5 0 obj<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>endobj',
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object."\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 6\n";
        $pdf .= "0000000000 65535 f \n";

        for ($index = 1; $index <= 5; $index++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$index]);
        }

        $pdf .= "trailer<< /Root 1 0 R /Size 6 >>\n";
        $pdf .= "startxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }
}

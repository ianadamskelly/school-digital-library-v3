# School Digital Library V3

A Laravel 12 application for managing a school digital library. Teachers can upload and organize books, recommend them to students, and monitor reading progress. Students can browse books, open them in a browser-based PDF reader, and continue from where they stopped.

## Features

### Teachers
- Upload PDF books and optional cover images to local storage
- Add books from a dedicated `Add Book` page
- Organize books by category and assign them to one or more grade groups
- Recommend books to students with optional notes
- Track assigned-student reading progress from the dashboard

### Students
- Browse books filtered by title, author, category, and grade group
- Read books in an in-browser PDF reader
- Resume reading from saved progress
- View recommendations from teachers

### Reader and upload improvements
- Books and cover images are stored locally on the Laravel `public` disk
- The PDF reader loads the first page first, then fetches remaining pages in smaller steps for slower connections
- Upload validation errors are shown clearly on the dedicated add-book page

## Current grade groups

- Pre-School
- Play Group
- Kindergarten
- Lower Primary
- Upper Primary
- Junior Secondary
- High School
- College
- University
- Adult Learning
- Other

## Example categories

- Story Books
- Textbooks
- Reference Books
- Picture Books
- Early Readers
- Children Fiction
- Young Adult
- Science & Nature
- History & Culture
- Mathematics
- Languages
- Comics
- Poems
- Plays
- Revision Material
- Life Skills
- Religion & Values
- Other

## Tech stack

- Laravel 12
- PHP 8.2+
- Tailwind CSS
- Alpine.js
- MySQL / MariaDB
- Smalot PDF Parser

## Setup

### Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL or MariaDB

### Installation

1. Clone the repository
   ```bash
   git clone https://github.com/ianadamskelly/school-digital-library-v3.git
   cd school-digital-library-v3
   ```

2. Install dependencies
   ```bash
   composer install
   npm install
   ```

3. Create the environment file and app key
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure `.env`
   - Set your database credentials
   - Set `APP_ENV=local` for development

5. Run migrations and seed base data
   ```bash
   php artisan migrate --seed
   ```

6. Link public storage
   ```bash
   php artisan storage:link
   ```

7. Start the app
   ```bash
   npm run dev
   php artisan serve
   ```

## Default seeded data

The seeder creates:
- Grade groups for early years through adult learning
- Book categories used by the upload form
- A sample teacher account:
  - Email: `john@example.com`
  - Password: `password`

## Storage

- Uploaded PDFs are stored in `storage/app/public/books/pdfs`
- Cover images are stored in `storage/app/public/books/covers`
- Public URLs are served through `public/storage`

## Testing

Run the test suite with:

```bash
php artisan test --compact
```

## License

This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

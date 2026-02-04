# School Digital Library - V3

A modern, web-based digital library management system designed for schools. This application allows teachers to upload and manage educational resources, while providing students with an intuitive interface to explore and read books.

## 🌟 Key Features

### For Teachers
- **Easy Book Management**: Upload PDF books directly to Google Drive storage.
- **Categorization**: Organize books into categories like Story Books, Textbooks, Reference Books, and more.
- **Grade Tagging**: Assign books to multiple grade levels (from Play Group to Grade 12).
- **Student Recommendations**: Personalized book recommendations for specific students with custom notes.
- **Progress Tracking**: Monitor student reading activity and completion rates.

### For Students
- **Digital Reader**: Read PDF books directly in the browser with a sleek, responsive reader.
- **Advanced Filtering**: Quickly find books by searching titles/authors or filtering by category and grade level.
- **Personalized Dashboard**: See your reading progress, teacher picks, and books you're currently reading.
- **Reading Progress**: Automatically saves your place—pick up exactly where you left off.

## 🛠 Tech Stack
- **Framework**: [Laravel 12+](https://laravel.com)
- **Frontend**: [Tailwind CSS](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
- **Database**: MySQL/MariaDB
- **Storage**: [Google Drive API](https://developers.google.com/drive) (via Flysystem)
- **PDF Processing**: [Smalot PDF Parser](https://github.com/smalot/pdfparser)

## 🚀 Getting Started

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- Google Cloud Service Account (for Google Drive storage)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/ianadamskelly/school-digital-library-v3.git
   cd school-digital-library-v3
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Configure your database and Google Drive credentials in `.env`.*

4. **Initialize Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Run Development Server**
   ```bash
   npm run dev
   # In a separate terminal
   php artisan serve
   ```

## 🔐 Security Note
Important sensitive files like `service-account.json` and `.env` are excluded from version control to protect credentials. Ensure you provide your own Google Service Account credentials for full functionality.

## 📄 License
This project is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

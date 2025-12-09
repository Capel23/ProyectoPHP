<?php

namespace App\Models;

use App\Core\Database;

class Post
{
    private int $id;
    private int $userId;
    private string $title;
    private string $slug;
    private string $content;
    private ?string $imagePath;
    private string $publishedAt;

    public function __construct(
        int $id,
        int $userId,
        string $title,
        string $slug,
        string $content,
        ?string $imagePath = null,
        string $publishedAt = ''
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->title = $title;
        $this->slug = $slug;
        $this->content = $content;
        $this->imagePath = $imagePath;
        $this->publishedAt = $publishedAt ?: date('Y-m-d H:i:s');
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getSlug(): string
    {
        return $this->slug;
    }
    public function getContent(): string
    {
        return $this->content;
    }
    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }
    public function getPublishedAt(): string
    {
        return $this->publishedAt;
    }

    public static function all(): array
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM posts ORDER BY published_at DESC");
        $posts = [];
        while ($row = $stmt->fetch()) {
            $posts[] = new self(
                (int)$row['id'],
                (int)$row['user_id'],
                $row['title'],
                $row['slug'],
                $row['content'],
                $row['image_path'],
                $row['published_at']
            );
        }
        return $posts;
    }

    public static function findBySlug(string $slug): ?self
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE slug = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $data = $stmt->fetch();

        if (!$data) return null;

        return new self(
            (int)$data['id'],
            (int)$data['user_id'],
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['image_path'],
            $data['published_at']
        );
    }

    public static function findById(int $id): ?self
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();

        if (!$data) return null;

        return new self(
            (int)$data['id'],
            (int)$data['user_id'],
            $data['title'],
            $data['slug'],
            $data['content'],
            $data['image_path'],
            $data['published_at']
        );
    }

    public static function create(int $userId, string $title, string $content, ?string $imagePath = null): bool
    {
        $slug = self::generateSlug($title);
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO posts (user_id, title, slug, content, image_path) 
            VALUES (:user_id, :title, :slug, :content, :image_path)
        ");
        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'image_path' => $imagePath
        ]);
    }

    public static function update(int $id, string $title, string $content, ?string $imagePath = null): bool
    {
        $slug = self::generateSlug($title);
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            UPDATE posts SET title = :title, slug = :slug, content = :content, image_path = :image_path WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'image_path' => $imagePath
        ]);
    }

    public static function delete(int $id): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    private static function generateSlug(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^a-z0-9\s-]/', '', $title)));
        $slug = preg_replace('/[\s-]+/', '-', $slug);

        $pdo = Database::getConnection();
        $base = $slug;
        $counter = 1;
        while (true) {
            $check = $pdo->prepare("SELECT id FROM posts WHERE slug = :slug");
            $check->execute(['slug' => $slug]);
            if (!$check->fetch()) break;
            $slug = $base . '-' . $counter++;
        }
        return $slug;
    }
}

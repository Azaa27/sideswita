<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_id', 'code', 'name', 'slug', 'description', 'price', 'stock', 'duration', 'image', 'youtube_video_id', 'is_active'];

    protected function casts(): array
    {
        return ['price' => 'decimal:2', 'is_active' => 'boolean'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Normalize a YouTube watch/share/embed URL (or a direct ID) to an 11-character video ID.
     * Only recognized YouTube hosts are accepted so the view never embeds an arbitrary domain.
     */
    public static function normalizeYoutubeVideoId(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $value)) {
            return $value;
        }

        $parts = parse_url($value);
        $host = strtolower((string) ($parts['host'] ?? ''));
        $id = null;

        if (in_array($host, ['youtu.be', 'www.youtu.be'], true)) {
            $id = trim((string) ($parts['path'] ?? ''), '/');
        }

        if (in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com', 'youtube-nocookie.com', 'www.youtube-nocookie.com'], true)) {
            parse_str((string) ($parts['query'] ?? ''), $query);
            $id = $query['v'] ?? null;

            if (!$id && preg_match('#/(?:embed|shorts|live)/([A-Za-z0-9_-]{11})#', (string) ($parts['path'] ?? ''), $matches)) {
                $id = $matches[1];
            }
        }

        return is_string($id) && preg_match('/^[A-Za-z0-9_-]{11}$/', $id) ? $id : null;
    }

    public function youtubeEmbedUrl(): ?string
    {
        if (!preg_match('/^[A-Za-z0-9_-]{11}$/', (string) $this->youtube_video_id)) {
            return null;
        }

        return 'https://www.youtube-nocookie.com/embed/'.$this->youtube_video_id.'?rel=0&modestbranding=1&playsinline=1';
    }

    public function youtubeWatchUrl(): ?string
    {
        return $this->youtubeEmbedUrl() ? 'https://www.youtube.com/watch?v='.$this->youtube_video_id : null;
    }
}

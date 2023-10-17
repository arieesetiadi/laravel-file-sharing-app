<?php

namespace App\Services;

use App\Models\Share;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class ShareService
{
    /**
     * Get all sharings data.
     */
    public function all(int $limit = 50): Collection
    {
        return Share::query()->take($limit)->latest()->get();
    }

    /**
     * Paginate all sharings data.
     */
    public function paginate(int $perPage = 10, bool $simple = true): Paginator
    {
        $pagination = Share::query()
            ->when(request()->status !== null, function ($query) { // Filter status
                return $query->where('status', request()->status);
            })
            ->latest();

        $result = match ($simple) {
            true => $pagination->simplePaginate($perPage),
            false => $pagination->paginate($perPage),
        };

        return $result;
    }

    /**
     * Get sharing by id.
     */
    public function find(string $id): Share
    {
        return Share::query()->find($id);
    }

    /**
     * Get sharing by sharing name.
     */
    public function findByName(string $name): Share
    {
        return Share::query()->where('name', $name)->first();
    }

    /**
     * Store new sharing data.
     */
    public function create(array $data): Share
    {
        return Share::query()->create($data);
    }

    /**
     * Update sharing data.
     */
    public function update(string $id, array $data): int
    {
        return Share::query()->find($id)->update($data);
    }

    /**
     * Delete sharing data.
     */
    public function delete(string $id): int
    {
        return Share::query()->find($id)->delete();
    }

    /**
     * Toggle sharing status.
     */
    public function toggleStatus(string $id): int
    {
        $sharing = Share::query()->find($id);
        $result = $sharing->update(['status' => !$sharing->status]);

        return $result;
    }
}

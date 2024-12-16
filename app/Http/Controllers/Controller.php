<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function success($data = [], string $message = null, int $status = 200)
    {
        $message = $message ?: __('successes.operation');
        return response()->json([
            'status' => __('successes.status'),
            'message' => $message,
            'data' => $data,
        ], $status);
    }
    protected function responsePagination($paginator, $data = [], string $message = null, int $status = 200)
    {
        if ($paginator instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $pagination = [
                'current_page' => $paginator->currentPage(),
                'total_pages' => $paginator->lastPage(),
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'links' => [
                    'first' => $paginator->url(1),
                    'last' => $paginator->url($paginator->lastPage()),
                    'prev' => $paginator->previousPageUrl(),
                    'next' => $paginator->nextPageUrl(),
                ],
            ];
        } else {
            $pagination = null;
        }

        $message = $message ?: __('successes.operation');
        return response()->json([
            'status' => __('successes.status'),
            'message' => $message,
            'data' => $data,
            'pagination' => $pagination,
        ], $status);
    }
    protected function error(string $message = null, int $status = 400)
    {
        $message = $message ?: __('errors.operation');
        return response()->json([
            'status' => __('errors.status'),
            'message' => $message,
        ], $status);
    }
    public function uploadPhoto($file, $path = 'uploads')
    {
        $photoName = time() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $photoName, 'public');
    }
    public function deletePhoto($path)
    {
        $fullpath = storage_path('app/public/' . $path);
        if (file_exists($fullpath)) {
            unlink($fullpath);
        }
        return;
    }
}

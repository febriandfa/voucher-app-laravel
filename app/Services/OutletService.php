<?php

namespace App\Services;

use App\Repositories\OutletRepository;
use Illuminate\Support\Facades\Validator;

class OutletService
{
    /**
     * Create a new class instance.
     */

    protected $outletRepository;

    public function __construct(OutletRepository $outletRepository)
    {
        $this->outletRepository = $outletRepository;
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validated();

        return $this->outletRepository->create($validatedData);
    }


    public function update($id, array $data)
    {
        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validated();

        $outlet = $this->outletRepository->findById($id);

        if (!$outlet) {
            throw new \Exception('Outlet not found');
        }

        return $this->outletRepository->update($outlet, $validatedData);
    }

    public function delete($id)
    {
        $outlet = $this->outletRepository->findById($id);

        if (!$outlet) {
            throw new \Exception('Outlet not found');
        }

        return $this->outletRepository->delete($outlet);
    }

    public function findById($id)
    {
        $outlet = $this->outletRepository->findById($id);

        if (!$outlet) {
            throw new \Exception('Outlet not found');
        }

        return $outlet;
    }

    public function getAll()
    {
        return $this->outletRepository->getAll();
    }
}

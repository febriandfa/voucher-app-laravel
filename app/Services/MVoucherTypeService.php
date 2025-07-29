<?php

namespace App\Services;

use App\Repositories\MVoucherTypeRepository;
use Illuminate\Support\Facades\Validator;

class MVoucherTypeService
{
    /**
     * Create a new class instance.
     */

    protected $mVoucherTypeRepository;

    public function __construct(MVoucherTypeRepository $mVoucherTypeRepository)
    {
        $this->mVoucherTypeRepository = $mVoucherTypeRepository;
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

        return $this->mVoucherTypeRepository->create($validatedData);
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

        $mVoucherType = $this->mVoucherTypeRepository->findById($id);

        if (!$mVoucherType) {
            throw new \Exception('Voucher type not found');
        }

        return $this->mVoucherTypeRepository->update($mVoucherType, $validatedData);
    }

    public function delete($id)
    {
        $mVoucherType = $this->mVoucherTypeRepository->findById($id);

        if (!$mVoucherType) {
            throw new \Exception('Voucher type not found');
        }

        return $this->mVoucherTypeRepository->delete($mVoucherType);
    }

    public function findById($id)
    {
        $mVoucherType = $this->mVoucherTypeRepository->findById($id);

        if (!$mVoucherType) {
            throw new \Exception('Voucher type not found');
        }

        return $mVoucherType;
    }

    public function getAll()
    {
        return $this->mVoucherTypeRepository->getAll();
    }
}

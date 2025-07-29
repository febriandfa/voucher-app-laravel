<?php

namespace App\Services;

use App\Repositories\VoucherRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VoucherService
{
    /**
     * Create a new class instance.
     */

    protected $voucherRepository;

    public function __construct(VoucherRepository $voucherRepository)
    {
        $this->voucherRepository = $voucherRepository;
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'm_voucher_type_id' => 'required|integer',
            'deskripsi' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_terbit',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validated();
        $validatedData['outlet_id'] = Auth::user()->outlet_id;

        return $this->voucherRepository->create($validatedData);
    }


    public function update($id, array $data)
    {
        $validator = Validator::make($data, [
            'm_voucher_type_id' => 'required|integer',
            'deskripsi' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after_or_equal:tanggal_terbit',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validated();
        $validatedData['outlet_id'] = Auth::user()->outlet_id;

        $voucher = $this->voucherRepository->findById($id);

        if (!$voucher) {
            throw new \Exception('Voucher not found');
        }

        return $this->voucherRepository->update($voucher, $validatedData);
    }

    public function delete($id)
    {
        $voucher = $this->voucherRepository->findById($id);

        if (!$voucher) {
            throw new \Exception('Voucher not found');
        }

        return $this->voucherRepository->delete($voucher);
    }

    public function claim(array $data)
    {
        $validator = Validator::make($data, [
            'voucher_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validated();

        $voucher = $this->voucherRepository->findById($validatedData['voucher_id']);

        if (!$voucher) {
            throw new \Exception('Voucher not found');
        }

        if ($voucher->status !== 'active') {
            throw new \Exception('Voucher is not active');
        }

        if ($voucher->tanggal_kadaluarsa < now()) {
            throw new \Exception('Voucher has expired');
        }

        if ($voucher->tanggal_terbit > now()) {
            throw new \Exception('Voucher has not started yet');
        }
    }

    public function findById($id)
    {
        $voucher = $this->voucherRepository->findById($id);

        if (!$voucher) {
            throw new \Exception('Voucher not found');
        }

        return $voucher;
    }

    public function getAll()
    {
        return $this->voucherRepository->getAll();
    }
}

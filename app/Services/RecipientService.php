<?php

namespace App\Services;

use App\Repositories\RecipientRepository;
use Illuminate\Support\Facades\Validator;

class RecipientService
{
    /**
     * Create a new class instance.
     */

    protected $recipientRepository;

    public function __construct(RecipientRepository $recipientRepository)
    {
        $this->recipientRepository = $recipientRepository;
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validated();

        return $this->recipientRepository->create($validatedData);
    }


    public function update($id, array $data)
    {
        $validator = Validator::make($data, [
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:15',
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $validatedData = $validator->validated();

        $recipient = $this->recipientRepository->findById($id);

        if (!$recipient) {
            throw new \Exception('Recipient not found');
        }

        return $this->recipientRepository->update($recipient, $validatedData);
    }

    public function delete($id)
    {
        $recipient = $this->recipientRepository->findById($id);

        if (!$recipient) {
            throw new \Exception('Recipient not found');
        }

        return $this->recipientRepository->delete($recipient);
    }

    public function findById($id)
    {
        $recipient = $this->recipientRepository->findById($id);

        if (!$recipient) {
            throw new \Exception('Recipient not found');
        }

        return $recipient;
    }

    public function getAll()
    {
        return $this->recipientRepository->getAll();
    }
}

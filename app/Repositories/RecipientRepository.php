<?php

namespace App\Repositories;

use App\Models\Recipient;

class RecipientRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return Recipient::create($data);
    }

    public function update(Recipient $recipient, array $data)
    {
        return $recipient->update($data);
    }

    public function delete(Recipient $recipient)
    {
        return $recipient->delete();
    }

    public function findById($id)
    {
        return Recipient::find($id);
    }

    public function getAll()
    {
        return Recipient::all();
    }
}

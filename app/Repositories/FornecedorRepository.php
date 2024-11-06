<?php

namespace App\Repositories;

use App\Models\Fornecedor;

class FornecedorRepository
{
    public function all()
    {
        return Fornecedor::paginate(10);
    }
}

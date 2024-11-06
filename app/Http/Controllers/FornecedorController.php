<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Rules\CpfOuCnpj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class FornecedorController extends Controller
{
    /**
     * Lista fornecedores com paginação e possibilidade de filtro por CPF ou CNPJ.
     */
    public function index(Request $request)
    {
        $query = Fornecedor::query();

        if ($request->has(key: 'documento')) {
            $query->where(column: 'documento', operator: $request->documento);
        }

        $fornecedores = $query->orderBy(column: 'nome')->paginate(perPage: 10);

        return response()->json(data: $fornecedores);
    }

    /**
     * Cria um novo fornecedor.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(data: $request->all(), rules: [
            'documento' => ['required', 'unique:fornecedores', new CpfOuCnpj],
            'nome' => 'required_without:nome_empresa',
            'nome_empresa' => 'required_without:nome',
            'contato' => 'required',
            'endereco' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(data: ['errors' => $validator->errors()], status: 422);
        }

        $fornecedor = Fornecedor::create(attributes: $request->all());

        if (strlen(string: $request->documento) === 14) {
            $response = Http::get(url: "https://brasilapi.com.br/api/cnpj/v1/{$request->documento}");
            if ($response->successful()) {
                $fornecedor->update([
                    'endereco' => $response->json(key: 'endereco'),
                ]);
            }
        }

        return response()->json(data: $fornecedor, status: 201);
    }

    /**
     * Atualiza um fornecedor existente.
     */
    public function update(Request $request, Fornecedor $fornecedor)
    {
        $validator = Validator::make(data: $request->all(), rules: [
            'documento' => ['required', new CpfOuCnpj],
            'nome' => 'required_without:nome_empresa',
            'nome_empresa' => 'required_without:nome',
            'contato' => 'required',
            'endereco' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(data: ['errors' => $validator->errors()], status: 422);
        }

        $fornecedor->update(attributes: $request->all());

        return response()->json(data: $fornecedor);
    }

    /**
     * Remove um fornecedor.
     */
    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();

        return response()->json(data: ['message' => 'Fornecedor removido com sucesso.']);
    }
}

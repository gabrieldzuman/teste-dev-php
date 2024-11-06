<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfOuCnpj implements Rule
{
    /**
     * Valida o CPF ou CNPJ.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $value = preg_replace(pattern: '/[^0-9]/', replacement: '', subject: $value);

        if (strlen(string: $value) === 11) {
            return $this->isValidCpf(cpf: $value);
        } elseif (strlen(string: $value) === 14) {
            return $this->isValidCnpj(cnpj: $value);
        }

        return false;
    }

    /**
     * Mensagem de erro para CPF ou CNPJ inválido.
     *
     * @return string
     */
    public function message(): string
    {
        return 'O :attribute deve ser um CPF ou CNPJ válido.';
    }

    /**
     * Valida o CPF.
     *
     * @param  string  $cpf
     * @return bool
     */
    private function isValidCpf($cpf): bool
    {
        if (preg_match(pattern: '/(\d)\1{10}/', subject: $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Valida o CNPJ.
     *
     * @param  string  $cnpj
     * @return bool
     */
    private function isValidCnpj($cnpj): bool
    {
        if (preg_match(pattern: '/(\d)\1{13}/', subject: $cnpj)) {
            return false;
        }

        for ($t = 12; $t < 14; $t++) {
            $d = 0;
            $pos = $t - 7;
            for ($c = 0; $c < $t; $c++) {
                $d += $cnpj[$c] * $pos--;
                if ($pos < 2) {
                    $pos = 9;
                }
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cnpj[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}

<?php
namespace App\Forms\Interfaces;

interface IForm
{
    public function getConfig(): array;
    public function getElements(): array;
    public function getMethod(): string;
    public function isSubmit(): bool;
}
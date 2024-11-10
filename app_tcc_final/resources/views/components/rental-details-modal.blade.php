{{-- resources/views/components/rental-details-modal.blade.php --}}
<div x-data="{ open: false }">
    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            Detalhes do Aluguel
        </x-slot>

        <x-slot name="content">
            <div>
                <p><strong>Fazenda:</strong> {{ $rental->farm->name }}</p>
                <p><strong>Quantidade de Animais:</strong> {{ $rental->animal_quantity }}</p>
                <p><strong>Preço por Cabeça:</strong> R$ {{ number_format($rental->price_per_head, 2, ',', '.') }}</p>
                <p><strong>Localização:</strong> {{ $rental->location }}</p>
                <p><strong>Duração do Aluguel:</strong> {{ $rental->rental_duration_days }} dias</p>
                <p><strong>Devolvido:</strong> {{ $rental->returned ? 'Sim' : 'Não' }}</p>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Fechar
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

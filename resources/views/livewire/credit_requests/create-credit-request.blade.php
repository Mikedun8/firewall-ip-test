<form wire:submit="save">
    <x-input-text name="title" wire:model.blur="title" />

    <x-input-text name="content" wire:model.blur="content" />

    <button type="submit">
        Save

        <!-- SVG loading spinner -->
        <div wire:loading>
            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <style>
                    .spinner_7WDj {
                        transform-origin: center;
                        animation: spinner_PBVY .75s linear infinite
                    }

                    @keyframes spinner_PBVY {
                        100% {
                            transform: rotate(360deg)
                        }
                    }
                </style>
                <path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"
                    opacity=".25" />
                <circle class="spinner_7WDj" cx="12" cy="2.5" r="1.5" />
            </svg>
        </div>

    </button>
</form>

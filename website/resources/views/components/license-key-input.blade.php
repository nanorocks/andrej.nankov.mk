<div wire:partial="schema-component::form.{{ $getStatePath() }}" data-field-wrapper
    class="fi-fo-field fi-fo-text-input-wrp" x-data="{
        generate() {
            const key = 'LIC-' + Math.random().toString(36).substring(2, 10).toUpperCase();
            $refs.input.value = key;
            $refs.input.dispatchEvent(new Event('input'));
        }
    }">
    {{-- Label (лево) --}}
    <div class="fi-fo-field-label-col">
        <div class="fi-fo-field-label-ctn">
            <label for="{{ $getId() }}" class="fi-fo-field-label">
                <span class="fi-fo-field-label-content">
                    {{ $getLabel() }}
                    @if ($isRequired())
                        <sup class="fi-fo-field-label-required-mark">*</sup>
                    @endif
                </span>
            </label>
        </div>
    </div>

    {{-- Input + Button (десно inline) --}}
    <div class="fi-fo-field-content-col">
        <div class="fi-input-wrp fi-fo-text-input">
            <div class="fi-input-wrp-content-ctn flex items-center gap-2">

                {{-- Input --}}
                <input x-ref="input" id="{{ $getId() }}" type="text" maxlength="255" @required($isRequired())
                    wire:model="{{ $getStatePath() }}" class="fi-input flex-1" />
            </div>
            {{-- Button (ист стил како Filament) --}}
            <button type="button" @click="generate" x-data="filamentFormButton"
                x-bind:class="{ 'fi-processing': isProcessing }"
                class="fi-color fi-color-primary fi-bg-color-400 hover:fi-bg-color-300
                           dark:fi-bg-color-600 dark:hover:fi-bg-color-700
                           fi-text-color-900 hover:fi-text-color-800
                           dark:fi-text-color-0 dark:hover:fi-text-color-0
                           fi-btn fi-size-md fi-ac-btn-action"
                x-bind:disabled="isProcessing">
                <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                    class="fi-icon fi-loading-indicator fi-size-md" x-show="isProcessing" style="display: none;">
                    <path clip-rule="evenodd"
                        d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                        fill-rule="evenodd" fill="currentColor" opacity="0.2">
                    </path>
                    <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                </svg>

                <span x-show="! isProcessing">Generate</span>
                <span x-show="isProcessing" x-text="processingMessage" style="display: none;"></span>
            </button>

        </div>
    </div>
</div>

<input type="radio" {{ $i == 0 ? 'checked' : '' }} name="aulaaovivo_id" id="duracao_{{ $a->id }}" value="{{ $a->id }}">
<label for="duracao_{{ $a->id }}" class="duracao-aula" data-valor="{{ currencyToApp($a->valor) }}">{{ $a->duracao }} min</label>
<div class="modal_schedule modal-agendar">
    <span class="close" data-close=".modal_schedule">Fechar [x]</span>
    <div class="modal_schedule_content">

        <div class="modal_schedule_content_header">
            <p>Agende uma aula com <span>{{ $professor->present()->fullName() }}</span></p>
        </div>

        <form data-action="{{ route('sistema.aovivo.agendaaula', $professor->id) }}" class="form-agenda">
            <div class="form-group">
                <label for="inputCategory">Categoria</label>
                {!! Form::select('categoriaaovivo_id', [null => 'Selecione'] + $professor->present()->categoriasAulas(), null, ['class' => 'form-control categoria-cart', 'data-url' => route('sistema.aovivo.getaulas', $professor->id)]) !!}
            </div>

            <div class="form-group mb-0">
                <label for="inputName">Selecione o Tempo da aula</label>
                <div class="radio">
                    Selecione uma categoria
                </div>
            </div>

            <div class="form-group mb-0 quantidade d-none">
                <div class="row">
                    <div class="col-xl-2 col-4">
                        <label for="">Quantidade:</label>
                        <input type="number" name="qtd" min="1" value="1" class="form-control">
                    </div>
                </div>
            </div>

            <div class="submit">
                <p><span>Valor por aula</span> <span class="valor">Selecione uma aula</span></p>
                <button type="submit" class="disabled btn-submit" disabled>Próximo</button>
            </div>
        </form>

        <p class="info">Os descontos e promoções estarão presentes na próxima página</p>
    </div>
</div>
<div class="modal_cart modal_boleto">
    <div class="modal_cart_content relative">
        <div class="modal_cart_header">
            <p><i class="fas fa-wallet"></i> Seu Boleto</p>
            <a title="Fechar" class="close" data-close=".modal_cart">Fechar</a>
        </div>
        <div class="modal_cart_body flex-column relative">
            <iframe src="{{ session('urlBoleto') }}" frameborder="0" height="600px" style="height: 80vh"></iframe>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center" style="margin-top:100px">
        <div class="col-sm-12" align="center">
            <a target="_blank" href="http://ww3.uag.ufrpe.br/">
            </a>
        </div>
    </div>

    <p>
        {{-- face="Times New Roman" font size="4" color="black"> --}}
        Olá, {{$movimento->userDestino->name}}.<br>
        Há uma nova solicitação de movimentação para você.
    </p>
    <a href="{{route('home')}}">SIGEPAT - LMTS</a>
</div>

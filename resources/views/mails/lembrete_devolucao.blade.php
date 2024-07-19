<div class="container">
    <div class="row justify-content-center" style="margin-top:100px">
        <div class="col-sm-12">
            <a target="_blank" href="http://ww3.uag.ufrpe.br/">
            </a>
        </div>
    </div>

    <p>
        {{-- face="Times New Roman" font size="4" color="black"> --}}
        Olá, {{$movimento->userOrigem->name}}.<br>
        Passando para lembrar que o prazo limite para devolução é hoje.
    </p>
    <a href="{{route('home')}}">SIGEPAT - LMTS</a>
</div>

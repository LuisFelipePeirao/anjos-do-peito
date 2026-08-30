Criei o componente reutilizável confirm-modal.blade.php. O botão “Sair” da sidebar já está usando-o como exemplo real.
Para exclusão:
<button type="button" data-confirm-dialog-open="delete-item">
    Excluir
</button>

<x-app.confirm-modal
    id="delete-item"
    title="Excluir registro?"
    message="Essa ação não poderá ser desfeita."
    confirm-label="Excluir"
    variant="danger"
    :action="route('items.destroy', $item)"
    method="DELETE"
/>
Para sair ou redirecionar:
<button type="button" data-confirm-dialog-open="leave-page">
    Sair
</button>

<x-app.confirm-modal
    id="leave-page"
    title="Sair desta tela?"
    message="As alterações não salvas serão perdidas."
    confirm-label="Sair"
    variant="warning"
    :href="route('home')"
/>

Variantes disponíveis: danger, warning e default. O modal fecha pelo botão, backdrop ou Esc, e devolve o foco ao acionador.
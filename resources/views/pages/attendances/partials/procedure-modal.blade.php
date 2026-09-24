<x-app.entity-manager-modal
    dialog-id="attendance-procedure-dialog"
    title="Gerenciar procedimentos"
    description="Cadastre, edite ou inative procedimentos."
    :store-action="route('attendances.procedures.store')"
    update-route="attendances.procedures.update"
    toggle-route="attendances.procedures.toggle"
    :items="$allProcedures"
    entity-label="procedimento"
    name-placeholder="Nome do procedimento"
    empty-message="Nenhum procedimento cadastrado."
    :input-class="$inputClass"
    error-bag="procedure"
/>

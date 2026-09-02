<x-app.entity-manager-modal
    dialog-id="attendance-category-dialog"
    title="Gerenciar população atendida"
    description="Cadastre, edite ou inative categorias de atendimento."
    :store-action="route('attendances.categories.store')"
    update-route="attendances.categories.update"
    toggle-route="attendances.categories.toggle"
    :items="$allAttendanceCategories"
    entity-label="categoria"
    name-placeholder="Nome da população atendida"
    empty-message="Nenhuma categoria cadastrada."
    :input-class="$inputClass"
    error-bag="attendanceCategory"
/>

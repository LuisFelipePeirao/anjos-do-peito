<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#ecfdf3] text-[#23845a]"><x-lucide-clipboard-list class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Registro clínico</h3><p class="mt-1 text-sm text-[#667085]">Resumo, objetivo, avaliação e conduta definida pela equipe.</p></div></div></div>
    <div class="grid gap-5 p-5 md:grid-cols-2">
        <x-material.floating-input name="summary" label="Resumo" :value="old('summary', $attendanceData['summary'])" placeholder="Ex.: Orientações sobre amamentação e pega correta" wrapper-class="md:col-span-2" />
        <x-material.floating-textarea name="objective" label="Objetivo" :value="old('objective', $attendanceData['objective'])" wrapper-class="md:col-span-2" />
        <x-material.floating-textarea name="complaint" label="Queixa principal" :value="old('complaint', $attendanceData['complaint'])" />
        <x-material.floating-textarea name="evaluation" label="Avaliação" :value="old('evaluation', $attendanceData['evaluation'])" />
        <x-material.floating-textarea name="conduct" label="Conduta" :value="old('conduct', $attendanceData['conduct'])" wrapper-class="md:col-span-2" />
    </div>
</article>
<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fff7e6] text-[#b76b00]"><x-lucide-forward class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Observações</h3><p class="mt-1 text-sm text-[#667085]">Informações complementares para acompanhamento interno.</p></div></div></div>
    <div class="p-5"><x-material.floating-textarea name="notes" label="Observações internas" :value="old('notes', $attendanceData['notes'])" /></div>
</article>

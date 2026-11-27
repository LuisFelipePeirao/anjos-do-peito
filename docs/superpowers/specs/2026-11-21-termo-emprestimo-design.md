# Termo de empréstimo

Desenho aprovado na conversa: ao cadastrar com “Sim”, salvar os dados originais do termo no banco e abrir um PDF em modal. Com “Não”, não salvar termo nem oferecer emissão. A aba Empréstimos oferece “Emitir termo” para registros que possuem esses dados.

## Abordagens

- Guardar PDF original: preserva documento, mas exige armazenamento de arquivos.
- Gerar com dados atuais: simples, mas altera conteúdo após cadastro.
- **Escolhida:** guardar cópia dos dados no cadastro e gerar PDF sob demanda exclusivamente dessa cópia. Não armazenar arquivo PDF.

Conteúdo: beneficiária, equipamento, responsável pela retirada, período, condições financeiras, pagamentos existentes e linhas para assinatura. Gerar não significa assinar. Acesso autenticado e restrito a perfis de gestão. Registros antigos não recebem cópias reconstruídas com dados atuais.

Decisões de implementação: JSON nullable na cessão; Dompdf para PDF real; modal nativo existente com link alternativo para abrir/baixar; geração após commit para que falhas de renderização não percam empréstimo cadastrado. Sem assinatura digital ou atualização do documento após cadastro.

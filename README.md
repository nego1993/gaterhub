# Gaterhub: Conectando Conhecimento e Comunidade

Bem-vindo ao **Gaterhub**, uma plataforma em desenvolvimento projetada para unir entusiastas e profissionais em discussões ricas sobre tópicos essenciais como:

- **Programação**: De algoritmos a frameworks modernos.
- **Contabilidade**: Ferramentas, normas e estratégias financeiras.
- **Administração**: Gestão, liderança e eficiência organizacional.
- **Marketing**: Campanhas, SEO e tendências digitais.

Estamos construindo algo grande, com potencial para se tornar um projeto **open source**. Este é o lugar para aprender, compartilhar e colaborar. Quer fazer parte disso? Continue lendo!

---

## Status do Projeto
🚧 **Em Construção**  
Estamos no início, mas já definimos uma base sólida. Acompanhe o progresso e junte-se a nós para moldar o futuro do fórum!

---

## Tecnologias Utilizadas
Nosso stack técnico é moderno, eficiente e preparado para escalar. Aqui está o que usamos e por quê:

- **[Laravel 11](https://laravel.com/)**  
  - **Por quê?** Backend robusto com ORM (Eloquent), rotas RESTful e autenticação nativa.  
  - **Detalhes:** Usamos o Laravel como API REST para gerenciar usuários, tópicos e postagens, aproveitando o `Sanctum` para autenticação baseada em tokens.  
  - **Estrutura:** Models como `User`, `Topic` e `Post`, com migrations para uma base MySQL.

- **[Inertia.js](https://inertiajs.com/)**  
  - **Por quê?** Integração perfeita entre backend e frontend, oferecendo uma experiência SPA sem a complexidade de uma API separada.  
  - **Detalhes:** Usamos o adaptador Vue para conectar as rotas Laravel diretamente aos componentes Vue 3, eliminando a necessidade de chamadas manuais à API no frontend.  
  - **Exemplo:** A sidebar dinâmica é renderizada via Inertia com dados compartilhados pelo `HandleInertiaRequests` middleware.

- **[Vue 3](https://vuejs.org/)**  
  - **Por quê?** Reatividade e componentização para um frontend interativo e modular.  
  - **Detalhes:** Utilizamos a Composition API com `<script setup>` para componentes como `MenuSidebar.vue`, combinada com Tailwind CSS para estilização responsiva.  
  - **Funcionalidades:** Dropdowns dinâmicos para menus com `ic_raiz === 1` e estado reativo com `ref`.

**Outras Ferramentas:**  
- **Tailwind CSS**: Estilização rápida e responsiva.  
- **Postgres**: Banco relacional para dados estruturados.  
- **Vite**: Build tool para um desenvolvimento frontend mais rápido.

---

## Por que este Projeto?
Queremos criar um hub de conhecimento onde:  
- Programadores troquem códigos e soluções.  
- Contadores debatam boas práticas fiscais.  
- Administradores compartilhem estratégias de gestão.  
- Marketeiros explorem campanhas inovadoras.  

Nosso foco é simplicidade, usabilidade e comunidade. Com uma arquitetura técnica bem planejada, estamos prontos para crescer!

---

## Estrutura Técnica
Aqui está uma visão geral da arquitetura atual:  

📂 Gaterhub
├── 📂 app
│   ├── 📂 Http
│   │   ├── 📂 Controllers (API e Inertia controllers)
│   │   └── 📂 Middleware (ex.: HandleInertiaRequests)
│   ├── 📂 Models (User, Topic, Post, Menu)
│   └── 📂 Providers
├── 📂 database
│   └── 📂 migrations (tabelas como menus, topics, posts)
├── 📂 resources
│   ├── 📂 js
│   │   ├── 📂 Components (ex.: MenuSidebar.vue)
│   │   └── 📂 Pages (ex.: Home.vue, Forum.vue)
│   └── 📂 css (Tailwind config)
├── 📂 routes
│   ├── 📂 api.php (rotas como /api/menu/index)
│   └── 📂 web.php (rotas Inertia)
└── 📂 public


## Como Contribuir
Estamos abertos a colaborações! Veja como você pode ajudar:  
1. **Issues**: Sugira features (ex.: suporte a Markdown em postagens).  
2. **Pull Requests**: Implemente melhorias (ex.: otimizar queries no Eloquent).  
3. **Testes**: Experimente e reporte bugs.  

**Exemplo de Contribuição:**  
- Adicionar um filtro nos tópicos por categoria no backend (`TopicController`).  
- Criar um componente Vue para exibir postagens em tempo real.

---

## Próximos Passos
- [ ] Estrutura básica do fórum (CRUD para tópicos e postagens).  
- [ ] Autenticação com Laravel Sanctum e perfis de usuário.  
- [ ] Categorias dinâmicas no frontend com Vue.  
- [ ] Suporte a Markdown com `marked` ou similar.  
- [ ] Tornar o projeto open source com docs detalhadas.


---

## Instalação (Local)
1. Clone o repositório:  
   ```bash
   git clone https://github.com/seu-usuario/forum-multi-temas.git
2. Instale dependências
    composer install
    npm install
3. Configure o .env
    Copie o .env_example para .env
    Defina DB_DATABASE, DB_USERNAME, e DB_PASSWORD.
4. rode as migrations
    php artisan migrate
5. inicie o servidor
    composer run dev

Junte-se à Jornada
O Gaterhub está nascendo, e você pode ser parte disso! Dê uma ⭐ no repositório, contribua com código ou ideias e ajude a criar algo incrível para a comunidade.

Licença: Em breve (a definir quando open source).

---

### Instruções:
1. Salve esse conteúdo em um arquivo chamado `README.md` na raiz do seu projeto.
2. Substitua `https://github.com/seu-usuario/geterhub.git` pelo URL real do seu repositório quando ele for criado.
3. Adicione seu email ou link de contato na seção **Contato**.
4. Se quiser, inclua badges no topo (ex.: status do build, versão do Laravel) usando serviços como Shields.io.

Está pronto para ser usado! Se precisar de mais ajustes ou quiser adicionar algo específico, é só me avisar!

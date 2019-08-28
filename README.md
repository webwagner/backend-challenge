Backend challenge
=============

Este é um desafio para backend. O objetivo deste desafio é avaliar seu conhecimento técnico e capacidade de desenvolver uma aplicação organizada, componentizada e funcional.
Você deverá fazer um fork do repositório e ao final abrir um 'pull request'. Todo o processo será avaliado, não somente o desenvolvimento da aplicação.


# Stack
- Symfony 4.3 (preferencialmente) / Laravel
- Banco de dados relacional (mysql preferencialmente)

# Diferenciais
- Docker

# Objetivo

Você terá que desenvolver uma API REST para as seguintes entidades:

- Categorias
- Aulas
- Cursos


# Estrutura

## Construir endpoints no padrão CRUD para cada um dos módulos. Não se preocupe com listas de controle de acesso (ACL):

- Categorias
    - Nome (string, obrigatório)
    - descrição (string)
- Aulas (segmentadas por categorias)
    - Título (string, obrigatório)
    - Descrição (string)
    - Link de vídeo público - youtube, vimeo, etc. (string, obrigatório)
    - Categorias da aula (foreign key)
- Cursos (composto de aulas)
    - Título (string, obrigatório)
    - Descrição (string)
    - Tipo de público (string, obrigatório)
    - Aulas (foreign key)


# Premissas

Os endpoints devem estar no padrão REST. Os campos de chave estrangeiras devem ser criados e relacionados conforme as regras:
- Uma aula pode ter uma ou mais categorias
- Um curso deve ter uma ou mais aulas

Sua aplicação deve estar configurada para rodar fora de seu ambiente de desenvolvimento. Considere usar docker neste desafio. Você pode publicar em algum servidor próprio, mas ainda precisará submeter o código via 'PR'.

Sua aplicação deve estar coberta por testes.


# Considerações finais

Neste teste serão avaliados suas competências em:
- Git
- A stack definida
- Sua lógica
- Organização de código
- Manutenabilidade da aplicação
- Cobertura de teste

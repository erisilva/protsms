<p align="center"><img src="http://www.contagem.mg.gov.br/novoportal/wp-content/themes/pmc/images/logo-prefeitura-contagem.png"></p>

## Sobre

Sistema de gestão e controle e tramitação de protocolos para SMS (Secretaria Municipal de Saúde) de Contagem-MG.

O ProtRH foi constuído com a framework [Laravel](https://laravel.com/), na versão 5.7 e usa como front-end [Bootstrap 4.3](https://getbootstrap.com/).

Faz uso também das seguintes bibliotecas:

- [simple-qrcode](https://github.com/SimpleSoftwareIO/simple-qrcode)
- [laravel-fpdf](https://github.com/codedge/laravel-fpdf)
- [typeahead](https://github.com/corejavascript/typeahead.js)
- [bootstrap-datepicker](https://github.com/uxsolutions/bootstrap-datepicker)

## Requisitos

Os requisitos para executar esse sistema pode ser encontrado na [documentação oficial do laravel](https://laravel.com/docs/5.7):

- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension

## Instalação

Executar a migração das tabelas com o comando seed:

php artisan migrate --seed

Serão criados 4 usuários de acesso ao sistema, cada um com um perfíl de acesso diferente.

Login: adm@mail.com senha:123456, acesso total.
Login: gerente@mail.com senha:123456, acesso restrito.
Login: operador@mail.com senha:123456, acesso restrito, não pode excluir registros.
Login: leitor@mail.com senha: 123456, somente consulta.

## Funcionalidades

- Funcionários
- Setores
- Protocolos
- Tramitação dos documentos
- Anexação de arquivos

## Prefeitura Municipal de Contagem

[www.contagem.mg.gov.br](http://www.contagem.mg.gov.br/novoportal/)

## Contribuições

Caso queira contribuir com melhorias para esse sistema basta enviar um e-mail para erivelton.silva@contagem.mg.gov.br com suas solicitações, ficarei grato com sua ajuda.

## Guia de intalação

Requer:

- Servidor apache com banco de dados MySQL instalado, se aplicável, conforme requisitos mínimos
- [Composer](https://getcomposer.org/download/) instalado
- [Git client](https://git-scm.com/downloads) instalado

Dica: [CMDER](https://cmder.net/) é um substituto do console (prompt) de comandos do windows que já vem com o git client dentre muitas outras funcionalidades

### clonar o reposítório

git clone https://github.com/erisilva/protrh.git

### criar o banco de dados

para mysql

CREATE DATABASE protrh CHARACTER SET utf8 COLLATE utf8_general_ci;

### configurações iniciais

criar o arquivo .env de configurações:

php -r "copy('.env.example', '.env');"

editar o arquivo .env com os dados de configuração com o banco.

gerando a key de segurança:

php artisan key:generate

iniciando o store para os anexos:

php artisan storage:link

### migrações

php artisan migrate --seed

### executando

php artisan serve

## Licenças

O sistema de protocolos é código aberto licenciado sob a [licença MIT](https://opensource.org/licenses/MIT).






## Documentação

O sistema faz a gestão dos protocolos e suas tramitações entre os funcionários.

O principal objeto do sistema é o protocolo, ele pode ser criado por qualquer funcionário registrado no sistema.

Na criação do protocolo o funcionário poderá definir o tipo (tipificação ou assunto) desse protocolo e escrever um conteúdo, apos criado somente poderá ser alterado apenas pelo funcionário que o criou incluindo nessas alterações a prossibilidade de criar observações e anexar arquivos.

Cada protocolo recebe na criação um identificador númerico e autoincremental. 

Ao ser criado o protocolo este é definido automaticamente com situação de aberto. Um protocolo aberto significa que ele não foi tramitado para nenhum outro funcionário. O funcionário que criou o protocolo pode finaliza-lo, definindo sua situação como concluída ou cancelada. A situação cancelado é uma forma de desabilitar o protocolo, sem apaga-lo do sistema, essa opção pode ser usado em casos de erros de criação do protocolo.

Quando o protocolo for tramitado pra outro funcionário a situação dele mudará de aberto para "em tramitação".

É importante notar que quando o protocolo for tramitado pra outro funcionário este não poderá ser concluído até que o mesmo seja tramitado de volta ao funcionário que o criou. (ver isso)

Tramitação é o segundo objeto do sistema e é usado para marcar o fluxo desse protocolo entre os funcionários. Cada tramitação possui dois funcionários, o funcionário de orrigem que criou a tramitação e o funcionário de destino que receberá a tramitação. Cabe ao funcionário de destino marcar a tramitação como recebida e tramitar para outro funcionário, criando assim o fluxo. Além disso, o funcionário que recebe a tramitação (destino) pode incluir a tramitação anexos e observações em forma de texto.


## To do

- O funcionário terá acesso apenas aos próprios protocolos e aqueles que foram tramitados para ele (ou por ele)
- Cada funcionário deverá ter uma conta de acesso no sistema por e-mail
- cada funcionário será relacionado a um setor
- O sistema deverá permitir que o funcionário pesquise as tramitações
- Mostrar na tela principal os protocolos e tramitações relacionado ao profissional logado no sistema
- Opção de marcar a tramitação do objeto como recebido, adicionando data do recebimento
- Só poderá marcar como recebido a tramitação do usuário logado no sistema
- Data de validade para resposta, para resposta ?? 

-- Tramitação e protocolos devem possuir diferentes interfaces

-- Cada tramitação possui um funcionário de origem (que fez o cadastro) e um funcionário que receberá a tramitação
-- Somente o funcionário que receber a tramitação poderá marca-la como recebido
-- Quando a tramitação for criada deverá ou poderá ter uma data para sua validação
-- ao se dar por recebida a tramitação deverá ter um campo para colocar informações ou observações sobre o recebimento

-- Cada protocolo poderá ter um ou vários anexos, cada tramitação terá nenhum ou vários anexos, esses anexos podem ser acessados apenas pelo criador do protocolo e o que fez a tramitação
-- cada tramitação poderá ter nenhum ou várias observações que podem ser adicionada
-- cada tramitação poderá ter nenhum ou vários arquivos anexados
-- A tramitação assim que for recebida e tramitada para outro funcionário não poderá ser mais alterado

-- dois objetos: protocolo - tramitação

-- protocolo: funcionário que o abriu, somente esse poderá alterar as informações do protocolo
-- tramitação: funcionário que o abriu e funcionário remetente
-- tramitação possui dois estados: recebido (sim e não e data/hora) e funcionário remetente

-- O gerente do sistema poderá excluir protocolos, se possível, poderá também ter uma visão geral: ou seja ver todos protocolos e tramitações, inclusive exportar os dados como um todo

-- Cada protocolo deverá ter um campo texto aberto, uma tipologia, e uma situação: aberto, tramitação, concluído. Ao ser concluído o protocolo esse permitirá a a colocação de uma motivo(opcional), esse ciclo de vida deverá ser automatizado pelo sistema:
--- aberto
--- tramitação
--- concluído
--- cancelado
--- motivo conclusão

-- O protocolo a ser concluído ou cancelado esse não poderá mais ser tramitado e nem mesmo mais alterado, por isso deverá duas formas de ver o protocolo, a primeira permite a alteração, adição de comentários e anexação de arquivos, a outra apenas visualização das informações

-- verifica se tem acesso : se for gerente lista todos protocolos, senão lista somete os protocolos do funcionário logado : se o protocolo não for do usuário logado não se pode alterar (view 2), se for pode alterar (view 1)

-- quando for concluído ou cancelado o protocolo não poderá ser mais tramitado e nem alterado

-- O concluído poderá ser cancelado, encerrado, deferido, outros, isso deverá ser estudado.


-- cada tramitação possuirá um botão {{Recebido}} que preencherá uma data e um estado na tabela
-- cada tramitação terá um botão para tramitar, exceto se o protocolo em questão estiver já concluído


-- o protocolo terá um relacionamento com funcionario e COM SETOR, esse setor será o mesmo que o funcionário esteja cadastrado no momento da criação do protocolo, o objetivo de criar essa redundancia é fazer com que o protocolo não perca o histórico do mesmo.





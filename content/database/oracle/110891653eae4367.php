<h1>Как правильно соединяться с базой данных под Personal Oracle?</h1>
<div class="date">01.01.2007</div>


<p>user/password@2: Это так для Oracle SQL Plus, и более других его утилит. А в BDE надо оставить все как для соединения с сетевым сервером, (протокол TNS, имя пользователя, кодировку, интерфейсную DLL) только вместо имени сервера написать "2:". Это годится и для случая, когда на одной машине и сетевой сервер и приложение.</p>

<div class="author">Автор: Nomadic</div><p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

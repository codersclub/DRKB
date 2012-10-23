<h1>Как установить клиента InterBase</h1>
<div class="date">01.01.2007</div>


<p>1. Для Yaffil или FireBird последних билдов - ничего не надо, кроме gds32.dll в директориях поиска библиотек.</p>

<p>2. Для IB5, IB6 или старого FB первых билдов - надо дополнительно прописать в файле services строчку "gds_db 3050/tcp" {файл должен завершаться пустую строкой}.</p>

<p>3. Для IB5, дополнительно к п.2., добавить в ключ реестра:</p>

<p>HKLM\SOFTWARE\InterBase Corp\InterBase\CurrentVersion\RootDirectory</p>

<p>строковое значение - имя папки, в которой лежит файл ib_license.dat</p>

<p>4. В случае медленного подключения клиентов в сети TCP/IP попробуйте прописать адреса IB серверов в файле HOSTS.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

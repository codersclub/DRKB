<h1>Duplicate resource error (2)</h1>
<div class="date">01.01.2007</div>


<p>У вас есть исходный код VCL? Если да, то в этом случае ее можно всю перекомпилировать, добавив каталог к вашему библиотечному пути (Library path) в опциях среды (Environment Options | Library). Я думаю это нужно сделать, чтобы отделаться от этой ошибки. При другом способе необходимо вычислить вызывающую проблему директиву $R, временно удалить ее, и осуществить перекомпиляцию. Временно выключить директиву $R можно добавлением '.' перед $ (но это не единственный путь выключить ее). </p>
<p>Вероятно, вы сабкласситесь от VCL. Убедитесь в том, что идентификатор ресурса для вашей иконки уникальный. Просто загрузите ее в любой редактор ресурсов, и измените ее номер. После этого вы должны пересобрать вашу библиотеку. </p>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
<p class="note">Примечание от Vit</p>
<p>В 99% случаев эта ошибка возникает при установке компонента, так как при добавлении компонента к пакету Дельфи автоматически к проекту добавляет и ресурс, если же этот ресурс уже определён в исходном коде компонента то и возникает эта ошибка. Откройте или менеджер проекта или исходный код DPK файла и удалите оттуда ссылку на ресурс, оставив её только в исходном коде компонента.</p>

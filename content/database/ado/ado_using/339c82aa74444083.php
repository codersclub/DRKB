<h1>Сессия</h1>
<div class="date">01.01.2007</div>


<p>Из объекта-источника данных можно создавать объекты-сессии. Для этого используется метод</p>

<p>function CreateSession(const punkOuter: lUnknown; const riid: TGUID; out ppDBSession: lUnknown}: HResult; stdcall;</p>

<p>интерфейса iDBCreateSession. Сессия предназначена для обеспечения работы транзакций и наборов рядов.</p>


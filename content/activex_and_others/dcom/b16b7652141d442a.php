<h1>Настройка системы безопасности DCOM сервера</h1>
<div class="date">01.01.2007</div>


<p>Алексей Вуколов</p>
<p>Как я понял, основная проблема в DCOM, с которой сталкиваются разработчики - настройка системы безопасности. Далее описано, как были сделаны настройки безопасности у меня. </p>
<p>Создана группа, в которую включены пользователи, которым нужен доступ к данному DCOM серверу (назовем ее DCOM_DEBUG).</p>
<p>В DCOMCNFG : (это было добавлено и на сервере и на клиенте)</p>
<p>DefaultSecurity -&gt; Default Access Permissions</p>
<p>DCOM_DEBUG: Allow Access</p>
<p>SYSTEM: Allow Access</p>
<p>Everyone: Allow Access</p>
<p>2.DefaultSecurity -&gt; Default Launch Permissions</p>
<p>DCOM_DEBUG: Allow Launch</p>
<p>SYSTEM: Allow Launch</p>
<p>INTERACTIVE: Allow Launch</p>
<p>Everyone: Allow Launch</p>
<p>3.DefaultSecurity -&gt; Default Configuration Permissions</p>
<p>SYSTEM: Full Control</p>
<p>DCOM_DEBUG: Full Control</p>
<p>Everyone: Full Control</p>
<p>Установка этих параметров необходима, по-моему, потому, что контекст безопасности интерфейса передаваемого на сервер для нотификации клиента берется из установок по умолчанию.</p>
<p>Только на сервере.</p>
<p>Установки параметров безопасности для объекта были установлены точно такие же, за исключением того, что Everyone включена не была. На вкладке Identity был выбран пользователь, от имени которого запускается COM сервер. Одна тонкость: у пользователя, от имени которого запускается COM сервер должно быть право "Log on as batch job", иначе сервер не запустится (это право было дано всей группе DCOM_DEBUG). Если выбрать Interactive User, то сервер не запустится, в том случае если пользователь делает Logoff. В случае с Launching User происходили какие-то невнятные проблемы (видимо это было связано со спецификой решаемой мной задачи - DCOM сервер с поддержкой множественных клиентских соединений).</p>
<p><a href="https://www.delphikingdom.com" target="_blank">https://www.delphikingdom.com</a></p>


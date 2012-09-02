<h1>Как остановить или запустить IB сервис?</h1>
<div class="date">01.01.2007</div>



<p>Do you need to shutdown the Interbase db service e.g. for an installation program and afterwards restart it?</p>

<p>You could do this with a lot of Delphi code involving unit WinSvc and function calls to</p>

<p>OpenSCManager()</p>
<p>EnumServicesStatus()</p>
<p>OpenService()</p>
<p>StartService() or ControlService().</p>

<p>But luckily there is a much easier solution that uses the NET.EXE program which has been part of Windows since Windows for Workgroups (Wfw 3.11). Just create the two batch files</p>

<p>IBSTOP.BAT</p>
<p>IBSTART.BAT</p>

<p>and call them from your code. You may want to call them and wait for their termination.</p>

<p>IBSTOP.BAT</p>
<p>=============</p>
<p>@echo off</p>
<p>net stop "InterBase Guardian" &gt;NULL</p>
<p>net stop "InterBase Server" &gt;NULL</p>

<p>IBSTART.BAT</p>
<p>=============</p>
<p>@echo off</p>
<p>net start "Interbase Guardian" &gt;NULL</p>
<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

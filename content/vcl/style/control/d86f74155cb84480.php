<h1>Манифест Windows XP</h1>
<div class="date">01.01.2007</div>


<p>Итак, начнем с манифеста. Он представляет собой документ в формате XML, содержащий всю информацию, необходимую для взаимодействия приложения и библиотеки ComCtl32.dll версии 6.</p>
<p class="note">Примечание&nbsp;</p>
<p>Следует отметить, что манифесты широко используются во многих продуктах и технологиях, работающих в операционных системах Microsoft. С полной схемой XML манифеста вы можете ознакомиться в документации Microsoft MSDN.</p>
<p>Пример манифеста</p>
<pre>&lt;?xml version="1.0" encoding="UTF-8" standalone="yes"?&gt; 
&lt;assembly xmlns="urn:schemas-microsoft-com:asm.vl" manifestVersion="l.0"&gt; 
&lt;assemblyIdentity version="l.0.0.0" 
  processorArchitecture="X86" 
  name="CompanyName.ProductName.YourApp" 
  type="win32" 
/&gt; 
&lt;description&gt;Your application description here.&lt;/description&gt; 
&lt;dependency&gt; 
&lt;dependentAssembly&gt; 
&lt;assemblyIdentity 
  type="win32" 
  name="Microsoft.Windows.Common-Controls" 
  version="6.0.0.0" 
  processorArchitecture="X86" 
  publicKeyToken="6595b64144ccfldf" 
  language="*" 
/&gt; 
&lt;/dependentAss embly&gt; 
&lt;/dependency&gt; 
&lt;/assembly&gt; 
</pre>
<p>Обратите внимание, что в элементе</p>
<p>&lt;dependency&gt;</p>
<p>&lt;dependentAssemblу&gt;&nbsp;</p>
<p>&lt;assemblyldentity&gt;</p>
<p>описывается версия системной библиотеки, используемой приложением для отрисовки элементов управления.</p>
<p>При загрузке приложения операционная система Windows XP считывает манифест (если он есть) и получает информацию о том, что для выполнения приложения потребуется библиотека ComCtl32.dll версии 6.</p>
<p>Помимо этой информации манифест может содержать и другие необходимые сведения о приложении и условиях его работы. Например, общая информация о приложении и его версии представлены элементом</p>
<p>&lt;AssemblyIdentity&gt;</p>
<p>Вы можете добавить манифест в ваше приложение двумя способами:&nbsp;</p>
<p> использовать компонент TxpManifest;</p>
<p> добавить манифест в ресурсы приложения вручную.</p>


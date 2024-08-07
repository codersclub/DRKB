---
Title: Компонент TXPManifest
Date: 01.01.2007
---


Компонент TXPManifest
=====================

На странице Win32 Палитры компонентов Delphi 7 имеется компонент
TXPManifest. Будучи добавленным в проект, он обеспечивает компиляцию
манифеста Windows XP в исполняемый файл приложения. В качестве основы
используется стандартный манифест Delphi для Windows XP, содержащийся в
файле ресурсов Delphi7\\Lib\\WindowsXP.res:

    <assembly xmlns="urn:schemas-microsoft-com:asm.vl" manifestVersion="l.0">  
    <assemblyIdentity  
      type="win32" 
      name="DelphiApplication" 
      version="3.2.0.0"  
      processorArchitecture="*" />  
    <dependency> 
    <dependentAssembly> 
      Ossemblyldentity type="win32" 
      name="Microsoft.Windows.Common-Controls" 
      version="6.0.0.0" 
      publicKeyToken="6595b64144ccfldf"
      language="*" 
      processorArchitecture="*" />  
    </dependentAssembly> 
    </dependency>  
    </assembly> 

К сожалению, версия профаммного продукта (ProductVersion), а также любая
другая информация о версии, содержащаяся в проекте (файлы DOF и RES) и
настраиваемая в диалоге Project Options среды разработки Delphi, никак
не влияет на содержимое манифеста. Поэтому при настройке манифеста в
соответствии с потребностями приложения вам придется предварительно
отредактировать файл WindowsXP.res или поправить манифест прямо в
исполняемом файле. (Ввиду частых перекомпиляций проекта второй вариант
представляется довольно обременительным.)

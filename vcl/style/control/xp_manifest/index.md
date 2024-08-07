---
Title: Манифест Windows XP
Date: 01.01.2007
---


Манифест Windows XP
===================

Итак, начнем с манифеста. Он представляет собой документ в формате XML,
содержащий всю информацию, необходимую для взаимодействия приложения и
библиотеки ComCtl32.dll версии 6.

**Примечание **

Следует отметить, что манифесты широко используются во многих продуктах
и технологиях, работающих в операционных системах Microsoft. С полной
схемой XML манифеста вы можете ознакомиться в документации Microsoft
MSDN.

**Пример манифеста**

    <?xml version="1.0" encoding="UTF-8" standalone="yes"?> 
    <assembly xmlns="urn:schemas-microsoft-com:asm.vl" manifestVersion="l.0"> 
    <assemblyIdentity version="l.0.0.0" 
      processorArchitecture="X86" 
      name="CompanyName.ProductName.YourApp" 
      type="win32" 
    /> 
    <description>Your application description here.</description> 
    <dependency> 
    <dependentAssembly> 
    <assemblyIdentity 
      type="win32" 
      name="Microsoft.Windows.Common-Controls" 
      version="6.0.0.0" 
      processorArchitecture="X86" 
      publicKeyToken="6595b64144ccfldf" 
      language="*" 
    /> 
    </dependentAssembly> 
    </dependency> 
    </assembly> 

Обратите внимание, что в элементе

    <dependency>
    <dependentAssemblу>
    <assemblyldentity>

описывается версия системной библиотеки, используемой приложением для
отрисовки элементов управления.

При загрузке приложения операционная система Windows XP считывает
манифест (если он есть) и получает информацию о том, что для выполнения
приложения потребуется библиотека ComCtl32.dll версии 6.

Помимо этой информации манифест может содержать и другие необходимые
сведения о приложении и условиях его работы. Например, общая информация
о приложении и его версии представлены элементом

    <AssemblyIdentity>

Вы можете добавить манифест в ваше приложение двумя способами: 

- использовать компонент TxpManifest;
- добавить манифест в ресурсы приложения вручную.

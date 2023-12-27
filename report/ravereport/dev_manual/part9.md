---
Title: Компонент TRvProject
Date: 01.01.2007
---


Компонент TRvProject
====================

::: {.date}
01.01.2007
:::

Компонент TRvProject является ключом для доступа к визуальным отчетам,
создаваемым с помощью Rave. Обычно к вас только один компонент
TRvProject на все приложения, но при нужде Вы можете иметь их столько,
сколько нужно. Свойство ProjectFile определяет файл проекта вашего
приложения, в котором хранятся все определения отчета. Данный файл имеет
расширение .RAV и даже если это единственный файл он может хранить
столько определений отчета сколько необходимо. Когда вызывается метод 
Open  объекта TRaveReport, то данный файл загружается в память для
подготовки к печати или для изменений пользовательским дизайнером. Вы
должны обязательно вызвать метод  Close, как только вам не нужен файл
проекта или при закрытии вашего приложения. Любые изменения в проекте
отчета Вы можете сохранить, вызвав метод Save. TRvProject также имеет
несколько свойства и методов, такие как SelectReport, GetReportList,
ReportDescToMemo, ReportDesc, ReportName и ReportFullName, что делает
эффективным и простым создание интерфейса для ваших пользователей.
Посмотрите RAVEDEMO проект, как хороший пример создания интерфейса Rave.

Свойство Engine

Свойство Engine TRvProject позволяет вам определять альтернативный
движок для вывода. Это позволяет вам создавать свои пользовательские
диалоги настройки и просмотра через компонент TRvSystem или создавать
NDR потоки или файлы через компонент TRvNDRWriter.

Использование TRvProject

Далее показана базовая последовательность шагов, которую Вы должны
выполнить при использовании компоненты TrvProject в вашем приложении:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  ---- --------------------------------------------------------------------------------------------
  1)   Вызовите RvProject.Open; для открытия проекта отчета, определенном в свойстве ProjectFile.
  ---- --------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  ---- -----------------------------------------------------------------------------------------------------
  2)   Вызовите RvProject.GetReportList(ListBox1.Items,TRUE); для загрузки списка имен отчетов в ListBox1.
  ---- -----------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  ---- -----------------------------------------------------------
  3)   Когда пользователь щелкнет в ListBox1 (ListBox1.OnClick),
  ---- -----------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
  вызовите RvProject.SelectReport(ListBox1.Items\[ListBox1.ItemIndex\],TRUE); и затем RvProject.ReportDescToMemo(Memo1);  для выбора текущего отчета и копирования его описание в Memo1.
  ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  ---- ----------------------------------------------------------
  4)   Вызовите RvProject.Execute;  для печати текущего отчета.
  ---- ----------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  ---- -------------------------------------------------------------------------------------------------------------------------------------------------
  5)   Вызовите RvProject.Design; вызов дизайнера конченого пользователя для текущего отчета (доступен только через End User Designer License (EUDL)).
  ---- -------------------------------------------------------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  ---- --------------------------------------------------------------------------------------
  6)   Вызовите RvProject.Close; для закрытия проекта отчета и освобождения занятой памяти.
  ---- --------------------------------------------------------------------------------------
:::

Это просто обзор базовых действий для типичного приложения и показано
как вызывать методы и свойства TRvProject. Есть также и другие свойства
и методы, определенные в основном справочника, что дает вам большие
возможности. Для сохранения места в вашем приложении, Rave загружает
только Graphics, Standard и Reporting компоненты. Компоненты штрих кодов
(Barcode) и другие пользовательские компоненты должны быть
зарегистрированы и откомпилированы в приложение явно, если они
используются в отчете Rave. Далее список шагов для подключения
компонентов штрих кодов в ваше приложение:

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  ---- --------------------------------------------------------------------------------------------------
  1)   На форме, которая содержит компонент TRvProject для приложения, добавьте модуль RvCsBars в uses.
  ---- --------------------------------------------------------------------------------------------------
:::

::: {style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"}
  ---- --------------------------------------------------------------------------------------------
  2)   Определите событие TRvProject.OnCreate и вызовите метод  RaveRegister для модуля RvCsBars:
  ---- --------------------------------------------------------------------------------------------
:::

 

procedure TReportForm.RvProjectCreate(Sender: TObject);

begin

RvCsBars.RaveRegister;

end;

Два приведенных выше шага требуются для любого пользовательского
компонента, который может использоваться в Rave отчете. Если Вы не
корректно выполните приведенные шаги, то Вы получите такое сообщение об
ошибке \"Class TRavePostNetBarcode not found\", во время открытия
проекта.
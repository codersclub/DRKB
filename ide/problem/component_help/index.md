---
Title: Установка справки для сторонних компонент под Delphi 2005 и Delphi 2006
Author: phanatos
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Установка справки для сторонних компонент под Delphi 2005 и Delphi 2006
=======================================================================

Новый формат справки, используемый в d2005, d2006 использует файлы с
расширением HXI, HXS и ini. Хуже он или лучше предыдущих реализаций -
судить не имеет смысла, он просто есть и им приходится пользоваться. Для
установки справки для сторонних компонентов, например DevExpress нужно
сделать следующее:

1. Воспользоваться утилитой H2Reg.exe, поставляемой вместе с
BDS (../Help/Thirdparty) для каждого ini файла в поставке.

   Команда для регистрации будет выглядеть так

        "c:\Program Files\Borland\BDS\4.0\Help\Thirdparty\H2Reg.exe" -r -m "CmdFile=<path>HelpFile.ini" "UserDir1=<path>"

2. Перезапустить BDS. (Вещь, в общем-то не обязательная, но
желательная)

**Примечание для DevExpress:**  
перед регистрацией необходимо во всех ini
файлах заменить
строки типа %IDE\_Namespace\_Postfix% на bds4 (для D2006).

по материалам sql.ru


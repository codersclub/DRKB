---
Title: Без иконки в панели задач
Author: Neil J. Rubenking
Date: 01.01.2007
---

Без иконки в панели задач
=========================

::: {.date}
01.01.2007
:::

Автор: Neil J. Rubenking

Если вы не хотите, чтобы ваше приложение имело иконку в панели задач,
добавьте следующие строки в исходный код проекта:

    Application.CreateHandle;
    ShowWindow(Application.Handle, SW_HIDE);
    Application.ShowMainForm := FALSE;

Да, чуть не забыл, есть еще одна вещь. При нормальном поведении
TApplication создает дескриптор и показывает окно прежде, чем далее
начнет что-то \"происходить\". Чтобы избежать этого, вам необходимо
создать модуль, содержащий единственную строчку в секции initialization:

    IsLibrary := True;

\... и поместить этот модуль ПЕРВЫМ в .DPR-файле в списке используемых
модулей. Этим мы \"одурачиваем\" TApplication, и оно думает что оно
запущено из DLL, тем самым изменяя свое обычное поведение.
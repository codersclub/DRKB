---
Title: TComboBox.ReadOnly
Author: Fantasist
Date: 01.01.2007
---


TComboBox.ReadOnly
==================

::: {.date}
01.01.2007
:::

Иногда хочется сделать так, чтобы в комбобоксе, пользователь мог только
выбирать из списка но не вводить текст с клавиатуры.

Так можно включить "ComboBox.ReadOnly"

SendMessage(GetWindow(ComboBox1.Handle,GW\_CHILD), EM\_SETREADONLY, 1,
0);

а так выключить.

SendMessage(GetWindow(ComboBox1.Handle,GW\_CHILD), EM\_SETREADONLY, 0,
0);

При csDropDownList нельзя набирать для выбора, то есть если нажал "К"
а потом "О", то вначале выберется слово на "К" а потом на "О", а
так выберется слово на "КО", и текст нельзя из него копировать.

Автор: Fantasist

Взято с Vingrad.ru <https://forum.vingrad.ru>

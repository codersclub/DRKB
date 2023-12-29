---
Title: TProgressBar, который не отображает реального прогресса
Author: p0s0l
Date: 01.01.2007
---


TProgressBar, который не отображает реального прогресса
=======================================================

::: {.date}
01.01.2007
:::

Начиная с виньХР появились в системе забавные ProgressBar\'ы, которые не
отображают реального \"прогресса\", а лишь отображают, что что-нибудь
работает... такой же появляется при загрузки виндыХР (бегает пару
чёрточек слева вправо, а потом обратно возвращаются в начало). Такой же
прогресс отображается если в ХР выбрать изображение, в меню нажать на
Print (Печать), и в этом диалоге при выборе шаблона печати - тоже такого
стиля есть прогресс. (надеюсь, что теперь ясно что я имел в виду)

И сам вопрос: как такой сделать на делфи?

Судя по MSDN, надо


     const
      PBS_MARQUEE            = $08;
      PBM_SETMARQUEE         = WM_USER+10;
     
    ...
     
      with ProgressBar1 do
      begin
        SetWindowLong (Handle, GWL_STYLE, (GetWindowLong (Handle, GWL_STYLE) or PBS_MARQUEE));
        Perform(PBM_SETMARQUEE, 1, 50);
      end;

(вместо 50 поставь время перемещения кубиков)

Цитата (MSDN)

Use this message when you do not know the amount of progress toward
completion but wish to indicate that progress is being made. 

PS: чтобы это работало, нужно включить в прогу XP-манифест

Автор: p0s0l

Взято с Vingrad.ru <https://forum.vingrad.ru>

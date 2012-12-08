---
Title: Как спрятать окно при запуске приложения?
Author: Diamond Cat
Date: 01.01.2007
---


Как спрятать окно при запуске приложения?
=========================================

::: {.date}
01.01.2007
:::

oncreate формы ставишь Application.Showmainform:=false; собственно и все
, этим решается и вопрос с закладкой в таскбаре и с видимостью формы

Автор: Diamond Cat

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

Я пытаюсь создать приложение, помещающее во время запуска иконку в
системную область панели задач c надлежащим контекстным меню. Тем не
менее приложение все еще остается видимым в панели задач. Использование
Application.ShowMainForm:=False оказывается недостаточным.

Я тоже столкнулся с этой проблемой, но, к счастью, нашел ответ. Вот
маленький код, который классно справляется с проблемой.

    procedure TMainForm.FormCreate(Sender: TObject);
    begin
      Application.OnMinimize:=AppMinimize;
      Application.OnRestore:=AppMinimize;
      Application.Minimize;
      AppMinimize(@Self);
    end;
     
    procedure TMainForm.AppMinimize(Sender: TObject);
    begin
      ShowWindow(Application.Handle, SW_HIDE);
    end;

Взято с <https://delphiworld.narod.ru>

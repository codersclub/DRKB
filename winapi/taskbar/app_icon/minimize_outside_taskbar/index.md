---
Title: Как сделать, чтобы неглавная форма минимизировалась не на Taskbar, а выше него?
Date: 01.01.2007
---

Как сделать, чтобы неглавная форма минимизировалась не на Taskbar, а выше него?
===============================================================================

::: {.date}
01.01.2007
:::

    void __fastcall CreateParams(TCreateParams &Params);
     
    ...
     
    void __fastcall TForm1::CreateParams(TCreateParams &Params)
    {
    TForm::CreateParams(Params);
    Params.ExStyle |= WS_EX_APPWINDOW;
    Params.WndParent = GetDesktopWindow();
    }
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

---
Title: Как сделать, чтобы неглавная форма минимизировалась не на Taskbar, а выше него?
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Как сделать, чтобы неглавная форма минимизировалась не на Taskbar, а выше него?
===============================================================================

    void __fastcall CreateParams(TCreateParams &Params);
     
    ...
     
    void __fastcall TForm1::CreateParams(TCreateParams &Params)
    {
      TForm::CreateParams(Params);
      Params.ExStyle |= WS_EX_APPWINDOW;
      Params.WndParent = GetDesktopWindow();
    }




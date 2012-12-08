---
Title: Как выяснить, установлены ли в системе шрифты TrueType
Date: 01.01.2007
---

Как выяснить, установлены ли в системе шрифты TrueType
======================================================

::: {.date}
01.01.2007
:::

    function IsTrueTypeInstalled: bool;
    var
      {$IFDEF WIN32}
      rs : TRasterizerStatus;
      {$ELSE}
      rs : TRasterizer_Status;
      {$ENDIF}
    begin
      result := false;
      if not GetRasterizerCaps(rs, sizeof(rs)) then
        exit;
      if rs.WFlags and TT_AVAILABLE <> TT_AVAILABLE then
        exit;
      if rs.WFlags and TT_ENABLED <> TT_ENABLED then
        exit;
      result := true;
    end;

Взято с <https://delphiworld.narod.ru>

---
Title: Как найти все установленные компоненты?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как найти все установленные компоненты?
=======================================

    uses ToolsApi;
    {....}
    var
      a, i: Integer;
    begin
      with (BorlandIDEServices as IOTAPackageServices) do
      begin
        for a := 0 to GetPackageCount - 1 do
        begin
          for i := 0 to GetComponentCount(a) - 1 do
          begin
            {get each component name with GetComponentName(a, i);}
          end;
        end;
      end;
    end;


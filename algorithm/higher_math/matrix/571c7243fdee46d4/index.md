---
Title: Как инвертировать матрицу?
Date: 01.01.2007
---


Как инвертировать матрицу?
==========================

::: {.date}
01.01.2007
:::

    type 
      RCOMat = array of array of Extended; 
     
    var 
      DimMat: integer; 
     
    procedure InvertMatrix(var aa: RCOMat); 
    var 
      numb, nula1, ipiv, indxr, indxc: array of Integer; 
      i, j, l, kod, jmax, k, ll, icol, irow: Integer; 
      amax, d, c, pomos, big, dum, pivinv: Double; 
      ind: Boolean; 
    begin 
      for j := 0 to Pred(DimMat) do ipiv[j] := 0; 
     
      irow := 1; 
      icol := 1; 
      for i := 0 to Pred(DimMat) do 
      begin 
        big := 0; 
     
        for j := 0 to Pred(DimMat) do 
        begin 
          if (ipiv[j] <> 1) then 
          begin 
            for k := 0 to Pred(DimMat) do 
            begin 
              if (ipiv[k] = 0) then 
                if (Abs(aa[j, k]) >= big) then 
                begin 
                  big  := Abs(aa[j, k]); 
                  irow := j; 
                  icol := k; 
                end 
                else; 
            end; 
          end; 
        end; 
     
        ipiv[icol] := ipiv[icol] + 1; 
        if (irow <> icol) then 
        begin 
          for l := 0 to Pred(DimMat) do 
          begin 
            dum         := aa[irow, l]; 
            aa[irow, l] := aa[icol, l]; 
            aa[icol, l] := dum; 
          end; 
          for l := 0 to Pred(DimMat) do 
          begin 
            dum := aa[irow + DimMat + 1, l]; 
            aa[irow + DimMat + 1, l] := aa[icol + DimMat + 1, l]; 
            aa[icol + DimMat + 1, l] := dum; 
          end; 
        end; 
        indxr[i] := irow; 
        indxc[i] := icol; 
        if (aa[icol, icol] = 0) then; 
        pivinv         := 1.0 / aa[icol, icol]; 
        aa[icol, icol] := 1.0; 
        for l := 0 to Pred(DimMat) do aa[icol, l] := aa[icol, l] * pivinv; 
        for l := 0 to Pred(DimMat) do aa[icol + DimMat + 1, l] := 
            aa[icol + DimMat + 1, l] * pivinv; 
        for ll := 0 to Pred(DimMat) do 
        begin 
          if (ll <> icol) then 
          begin 
            dum          := aa[ll, icol]; 
            aa[ll, icol] := 0.0; 
            for l := 0 to Pred(DimMat) do aa[ll, l] := aa[ll, l] - aa[icol, l] * dum; 
            for l := 0 to Pred(DimMat) do aa[ll + DimMat + 1, l] := 
                aa[ll + DimMat + 1, l] - aa[icol + DimMat + 1, l] * dum; 
          end; 
        end; 
      end; 
     
      for l := Pred(DimMat) downto 0 do 
      begin 
        if (indxr[l] <> indxc[l]) then 
        begin 
          for k := 0 to Pred(DimMat) do 
          begin 
            dum := aa[k, indxr[l]]; 
            aa[k, indxr[l]] := aa[k, indxc[l]]; 
            aa[k, indxc[l]] := dum; 
          end; 
        end; 
      end; 
    end; 

Взято с сайта <https://www.swissdelphicenter.ch/en/tipsindex.php>

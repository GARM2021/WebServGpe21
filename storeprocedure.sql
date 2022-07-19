USE [gpe2022]
GO
/****** Object:  StoredProcedure [dbo].[SP_NewRecOf]    Script Date: 03/15/2022 09:34:19 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
/****** Object:  StoredProcedure [dbo].[SP_defaultb]    Script Date: 03/14/2022 09:48:37 ******/

ALTER procedure [dbo].[SP_NewRecOf]
@Expe char(14)


AS

BEGIN

SET NOCOUNT ON



DECLARE @sql nvarchar(MAX) 
DECLARE	@wcaja char(4) = '0805'
DECLARE @wfoliorec float
DECLARE @wgenerarecibo int = 0
DECLARE @sfoliorec char(12)
DECLARE @rowf int

    --//1EXTRAE NUMERO CONSECUTIVO DE RECIBO
    
    CREATE TABLE #sqlf (foliorec float)
    SET @sql  = 'INSERT INTO #sqlf ( foliorec) SELECT foliorec FROM [dbo].[ingresmcajas]  WHERE caja= @wcaja' 
  
    
    EXEC  sp_executesql @sql,  N'@wcaja char(4)', @wcaja  

  	SET @rowf = @@ROWCOUNT
	
	if @rowf > 0
	Begin
	

			
			  SELECT @wfoliorec = foliorec FROM #sqlf
			
			 -- SELECT @wfoliorec  -- DEB
			
			
			
			
			
			if @wgenerarecibo <> 99
			Begin
				 SET @wfoliorec = @wfoliorec + 1
				 
		  --   UPDATE [dbo].[ingresmcajas] set foliorec = @wfoliorec WHERE caja = @wcaja -- UPDATEINSERT 
				 
				 SET @sfoliorec = '0' + STR(@wfoliorec,11, 0)
				 
				 SET @wgenerarecibo = 99
				 
				 SELECT  @wfoliorec -- DEB
			 
			 
			 End
	
	End
	
	
DROP TABLE #sqlf

END


========================20220712===========================================
-- ================================================
-- Template generated from Template Explorer using:
-- Create Procedure (New Menu).SQL
--
-- Use the Specify Values for Template Parameters 
-- command (Ctrl-Shift-M) to fill in the parameter 
-- values below.
--
-- This block of comments will not be included in
-- the definition of the procedure.
-- ================================================
USE [guadalupe2018]
GO
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
CREATE PROCEDURE [dbo].[SP_Fine0] 
	-- Add the parameters for the stored procedure here
	@sine nvarchar(50)
AS
BEGIN
DECLARE @sql nvarchar(MAX) 
DECLARE @wnombre  nvarchar(50)
DECLARE @wpaterno  nvarchar(50)
DECLARE @wmaterno  nvarchar(50)
DECLARE @wsexo     nvarchar(50)
DECLARE @wgenerarecibo int = 0
DECLARE @sfoliorec char(12)
DECLARE @rowf int

    --EXTRAE NUMERO CONSECUTIVO DE RECIBO
    
  --  CREATE TABLE #sqlf (foliorec float)
  --  SET @sql  = 'INSERT INTO #sqlf ( foliorec) SELECT foliorec FROM [dbo].[ingresmcajas]  WHERE caja= @wcaja' 
  
    
   -- EXEC  sp_executesql @sql,  N'@wcaja char(4)', @wcaja  

  	--SET @rowf = @@ROWCOUNT
	
	--if @rowf > 0
	--Begin
	

			
	--		  SELECT @wfoliorec = foliorec FROM #sqlf
			
	--		 -- SELECT @wfoliorec  -- DEB
			
			
			
			
			
	--		if @wgenerarecibo <> 99
	--		Begin
	--			 SET @wfoliorec = @wfoliorec + 1
				 
	--	  UPDATE [dbo].[ingresmcajas] set foliorec = @wfoliorec WHERE caja = @wcaja -- UPDATEINSERT 
				 
	--			 SET @sfoliorec = '0' + STR(@wfoliorec,11, 0)
				 
	--			 SET @wgenerarecibo = 99
			
	--		SELECT  @sfoliorec as sfoliorec -- DEB
			 
	--		 End
	
--	End
	
	
--DROP TABLE #sqlf

	
END
GO

===========================================================================

 [cve]
      ,[edad]
      ,[nombre]
      ,[paterno]
      ,[materno]
      ,[fecnac]
      ,[sexo]
      ,[calle]
      ,[int]
      ,[ext]
      ,[colonia]
      ,[cp]
      ,[e]
      ,[d]
      ,[m]
      ,[s]
      ,[l]
      ,[mza]
      ,[consec]
      ,[cred]
      ,[folio]
      ,[nac]
      ,[curp]
  FROM [guadalupe2018].[dbo].[Nl]
GO
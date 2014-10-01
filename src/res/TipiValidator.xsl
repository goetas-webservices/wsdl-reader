<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" 

	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:php="http://php.net/xsl" 
	xmlns:xsd="http://www.w3.org/2001/XMLSchema" 
	xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/">
<xsl:output method="xml" encoding="utf-8" />
<xsl:param name="wsdlPath"></xsl:param>
<xsl:template match="/">
	<xsd:schema targetNamespace="{/wsdl:definitions/@targetNamespace}">
		<xsl:for-each select="/wsdl:definitions/wsdl:types/xsd:schema/xsd:import">	
			<xsl:variable name="schemapath" select="php:function('\ambient\soap\SoapServer::resolve_url',string($wsdlPath),string(@schemaLocation))"/>
			<xsd:import schemaLocation="{$schemapath}">
					<!-- <xsl:if test="@namespace">
						<xsl:attribute name="namespace"><xsl:value-of select="@namespace"/></xsl:attribute>
					</xsl:if> -->
				<!-- <xsl:if test="document($schemapath)/xsd:schema/@targetNamespace">
					<xsl:attribute name="namespace"><xsl:value-of select="document($schemapath)/xsd:schema/@targetNamespace"/></xsl:attribute>
				</xsl:if> -->
			</xsd:import>
		</xsl:for-each>
		<xsl:apply-templates/>
	</xsd:schema>
</xsl:template>

<xsl:template match="wsdl:portType/wsdl:operation">	
	<xsl:if test="count(wsdl:input)">
		<xsl:apply-templates select="." mode="internal" />
	</xsl:if>
</xsl:template>

<xsl:template match="wsdl:documentation">
	<xsl:comment><xsl:value-of select="."/></xsl:comment>
</xsl:template>

<xsl:template match="wsdl:operation" mode="internal">
	<xsl:comment>operazione <xsl:value-of select="name()"/></xsl:comment>
		<xsd:element name="{@name}" type="{wsdl:input/@message}" >
		</xsd:element>

</xsl:template>
<xsl:template match="wsdl:message">
	<xsd:complexType name="{@name}">
		<xsd:sequence>
			<xsl:apply-templates/>
		</xsd:sequence>
	</xsd:complexType>
</xsl:template>

<xsl:template match="wsdl:part">
	<xsd:element name="{@name}" type="{@type}" maxOccurs="1" minOccurs="1" />
</xsl:template>


</xsl:stylesheet>
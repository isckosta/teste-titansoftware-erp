<?php
    
    /**
     * Essa função serve para debugar variáveis, objetos ou array de forma mais rápida.
     * Para usar, você poderá chamá-la em qualquer arquivo onde o arquivo config.php tiver incluído.
     * @param $array_name
     * @return void
     */
    function dd($array_name): void
    {
        echo '<pre>';
        print_r($array_name);
        echo '</pre>';
    }
    
    /**
     * Essa função serve para formatar os valores de moedas exibidos no sistema.
     * Para usar, você poderá chamá-la em qualquer arquivo onde o arquivo config.php tiver incluído.
     * @param $value
     * @return string
     */
    function formatMoney($value): string
    {
        return number_format($value, 2, ',', '.');
    }
    
    /** Essa função serve para calcular o valor do desconto do produto de acordo com a cor selecionada.
     * @param $productPrice
     * @param $color
     * @return float|int|mixed
     */
    function calculateDiscountAccordingToColor($productPrice, $color): mixed
    {
        $productPriceWithDiscount = 0;
        
        switch ($color) {
            case "azul";
                $productPriceWithDiscount = percentage(20, $productPrice);
                break;
            case "vermelho";
                if ($productPrice > 50) {
                    return $productPriceWithDiscount = percentage(20, $productPrice);
                }
                $productPriceWithDiscount = percentage(5, $productPrice);
                break;
            case "amarelo";
                $productPriceWithDiscount = percentage(10, $productPrice);
                break;
            default:
                $productPriceWithDiscount = $productPrice;
            
        }
        
        return $productPriceWithDiscount;
    }
    
    /**
     * Função de porcentagem: Quanto é X% de N?
     * @param $percentage
     * @param $total
     * @return float|int
     */
    function percentage($percentage, $total): float|int
    {
        return ($percentage / 100) * $total;
    }
    
    /** Função pra exibir a cor do produto na linha da tabela <td>
     * @param $color
     * @return string
     */
    function showColor($color): string
    {
        $colorAttr = "";
        switch ($color) {
            case "Azul":
                $colorAttr = "blue";
                break;
            case "Vermelho":
                $colorAttr = "red";
                break;
            case "Amarelo":
                $colorAttr = "yellow";
                break;
            default:
                echo "none";
        }
        
        return $colorAttr;
    }
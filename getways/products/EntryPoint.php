<?php

namespace getways\products;

use getways\products\logic\CreateExtraProduct;
use getways\products\logic\CreateProduct;
use getways\products\logic\ExtraProductDelete;
use getways\products\logic\ExtraProductIndex;
use getways\products\logic\ExtraProductUpdate;
use getways\products\logic\menu;
use getways\products\logic\ProductDestroy;
use getways\products\logic\ProductDetails;
use getways\products\logic\Size;
use getways\products\logic\UpdateProduct;
use getways\products\repositories\ProductRepository;

class EntryPoint
{
    /************************************ products ************************************/
    public function allSizes(array $productData)
    {
        return (new Size(new ProductRepository()))->allSizes($productData);
    }
    public function allCategory(array $productData)
    {
        return (new Size(new ProductRepository()))->allCategory($productData);
    }
    public function createProduct(array $productData)
    {
        return (new CreateProduct(new ProductRepository()))->createProduct($productData);
    }
    public function updateProduct($productId, array $productData)
    {
        return (new UpdateProduct(new ProductRepository()))->updateProduct($productId, $productData);
    }
    public function menu(array $filter)
    {
        return (new Menu(new ProductRepository()))->menu($filter);
    }
    public function findProduct($productId)
    {
        return (new ProductDetails(new ProductRepository()))->findProduct($productId);
    }
    public function deleteProduct($productId)
    {
        return (new ProductDestroy(new ProductRepository()))->deleteProduct($productId);
    }
    public function createExtraProduct(array $productData)
    {
        return (new CreateExtraProduct(new ProductRepository()))->createProduct($productData);
    }
    public function updateExtraProductCategory(array $productData)
    {
        return (new ExtraProductUpdate(new ProductRepository()))->extraProductCategory($productData);
    }
    public function updateExtraProduct(array $productData)
    {
        return (new ExtraProductUpdate(new ProductRepository()))->extraProduct($productData);
    }
    public function deleteExtraProductCategory(array $productData)
    {
        return (new ExtraProductDelete(new ProductRepository()))->extraProductCategory($productData);
    }
    public function deleteExtraProduct(array $productData)
    {
        return (new ExtraProductDelete(new ProductRepository()))->extraProduct($productData);
    }
    public function extraProduct(array $productData)
    {
        return (new ExtraProductIndex(new ProductRepository()))->extraProduct($productData);
    }
    public function allExtraProductCategory($productId)
    {
        return (new ExtraProductIndex(new ProductRepository()))->extraProductCategory($productId);
    }
}

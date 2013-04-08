<?php

class testCategoryProvider extends testObjectProvider
{
    public static $model = 'Category';

    protected function valid_leaf_category()
    {
        return [
            '_id' => new MongoId( '4af9f23d8ead0e1d32000001' ),
            'name' => 'Ferramentas específicas',
            'parents' => [
                testCategoryProvider::saved('valid_parent_category')->_id 
            ],
            'description' => 'Ferramentas com finalidades específicas',
        ];
    }

    protected function another_valid_leaf_category()
    {
        return [
            '_id' => new MongoId( '4af9f23d8ead0e1d32000002' ),
            'name' => 'Ferramentas detalhadas',
            'parents' => [
                testCategoryProvider::saved('valid_parent_category')->_id 
            ],
            'description' => 'Ferramentas detalhadas',
        ];
    }

    protected function invalid_leaf_category()
    {
        return [
            '_id' => new MongoId( '4af9f23d8ead0e1d32000003' ),
            'name' => '',
            'parents' => [
                testCategoryProvider::saved('valid_parent_category')->_id 
            ],
            'description' => 'A chave de entrade sem nome!',
        ];
    }

    protected function valid_parent_category()
    {
        return [
            '_id' => new MongoId( '4af9f23d8ead0e1d32000004' ),
            'name' => 'Ferramentas',
            'parents' => [],
            'description' => 'Ferramentas em geral',
        ];
    }

    protected function another_valid_parent_category()
    {
        return [
            '_id' => new MongoId( '4af9f23d8ead0e1d32000005' ),
            'name' => 'Equipamentos',
            'parents' => [],
            'description' => 'Equipamentos em geral',
        ];
    }

    protected function valid_department()
    {
        return [
            '_id' => new MongoId( '4af9f23d8ead0e1d32000006' ),
            'name' => 'Coisas',
            'parents' => [],
            'description' => 'Departamento cheio de coisas',
        ];
    }

    protected function hidden_leaf_category()
    {
        return [
            '_id' => new MongoId( '4af9f23d8ead0e1d32000007' ),
            'name' => 'Brocas',
            'parents' => [
                testCategoryProvider::saved('valid_parent_category')->_id,
                testCategoryProvider::saved('another_valid_parent_category')->_id 
            ],
            'description' => 'Brocas com finalidades específicas',
            'hidden' => 1
        ];
    }
}

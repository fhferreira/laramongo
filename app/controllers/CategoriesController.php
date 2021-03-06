<?php

class CategoriesController extends BaseController {

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($id)
    {
        $category = Category::first($id);

        if(! $category || ! $category->isVisible())
        {
            return Redirect::action('HomeController@index')
                ->with( 'flash', 'Categoria não encontrada' );
        }

        if($category->kind == 'leaf')
        {
            $page = Input::get('page') ?: 1;

            $products = Product::where(['category'=>(string)$category->_id, 'deactivated'=>null])
                ->limit(12)
                ->skip( ($page-1)*12 );

            if( Input::get('ajax') || Request::ajax() )
            {
                // For ajax request, don't return the layout or the complete view
                return View::make('categories._products')
                    ->with( 'category', $category )
                    ->with( 'products', $products )
                    ->with( 'total_pages', round($products->count()/12) )
                    ->with( 'page', $page );
            }
            else
            {
                // For non ajax requests, return the layout with the view embeded
                $this->layout->content = View::make('categories.show')
                    ->with( 'category', $category )
                    ->with( 'products', $products )
                    ->with( 'total_pages', round($products->count()/12) )
                    ->with( 'page', $page );
            }
        }
        else
        {
            $subCategories = Category::where(['parents'=>$category->_id, 'hidden'=>['$ne'=>'true']]);

            $this->layout->content = View::make('categories.subcategories')
                ->with( 'category', $category )
                ->with( 'subCategories', $subCategories );
        }
    }
}

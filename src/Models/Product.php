<?php namespace Models;

class Product extends Model
{
    protected $table = 'products';

    protected $order = 'published_at';

    protected $limite = 20;
}
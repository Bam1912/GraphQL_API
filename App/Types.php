<?php

namespace App;

use App\Type\QueryType;
use App\Type\MutationType;

use App\Type\Query\UserType;
use App\Type\Query\CountryType;
use App\Type\Query\CityType;
use App\Type\Query\AnswerType;
// use App\Type\Query\SightType;
use App\Type\Query\PlaceType;
use App\Type\Query\PersonType;
use App\Type\Query\ChannelsType;
use App\Type\Query\LinksType;
use App\Type\Query\CompanyType;
use App\Type\Query\StorageType;
use App\Type\Query\FormType;
use App\Type\Query\FormInputsType;
use App\Type\Query\FormDataType;
use App\Type\Query\FileType;
use App\Type\Query\LandingSegmentType;
use App\Type\Query\LandingType;

use App\Type\Mutation\InputCountryType;
use App\Type\Mutation\InputUserType;
use App\Type\Mutation\InputCityType;
// use App\Type\Mutation\InputSightType;
use App\Type\Mutation\InputPlaceType;
use App\Type\Mutation\InputPersonType;
use App\Type\Mutation\InputCompanyType;
use App\Type\Mutation\InputStorageType;
use App\Type\Mutation\InputFileType;
use App\Type\Mutation\InputFormDataType;

use GraphQL\Type\Definition\Type;

/**
 * Class Types
 *
 * Реестр и фабрика типов для GraphQL
 *
 * @package App
 */
class Types
{
    /*@var QueryType */
    private static $query;

    /*@var MutationType */
    private static $mutation;

    /*@var UserType */
    private static $user;
    private static $inputUser;
    
    /*@var CountryType */
    private static $country;
    private static $inputCountry;
    
    /*@var CityType */
    private static $city;
    private static $inputCity;

    /*@var StoreType */
    private static $store;
    private static $inputStorage;

    /*@var FileType */
    private static $file;
    private static $inputFile;

    /*@var SightType */
    // private static $sight;
    // private static $inputSight;

    /*@var PlaceType */
    private static $place;
    private static $inputPlace;

    /*@var AnswerType */
    private static $answer;

    /*@var PersonType */
    private static $person;
    private static $inputPerson;
    
    /*@var LinksType */
    private static $links;

    /*@var ChannelsType */
    private static $channels;

    /*@var CompanyType */
    private static $company;
    private static $inputCompany;

    /*@var LandingType */
    private static $landing;
    private static $landingSegment;

    /*@var FormType */
    private static $form;
    private static $formInputs;

    /*@var FormDataType */
    private static $formData;
    private static $inputFormData;
    
    
    /*@return QueryType */
    public static function query() { return self::$query ?: (self::$query = new QueryType()); }

    /*@return MutationType */
    public static function mutation() { return self::$mutation ?: (self::$mutation = new MutationType()); }

    /*@return custom Types */
    public static function file() { return self::$file ?: (self::$file = new FileType()); }
    public static function inputFile() { return self::$inputFile ?: (self::$inputFile = new InputFileType()); }

    public static function storage() { return self::$store ?: (self::$store = new StorageType()); }
    public static function inputStorage() { return self::$inputStorage ?: (self::$inputStorage = new InputStorageType()); }

    public static function user() { return self::$user ?: (self::$user = new UserType()); }
    public static function inputUser() { return self::$inputUser ?: (self::$inputUser = new InputUserType()); }

    public static function country() { return self::$country ?: (self::$country = new CountryType()); }
    public static function inputCountry(){ return self::$inputCountry ?: (self::$inputCountry = new InputCountryType()); }

    public static function city() { return self::$city ?: (self::$city = new CityType()); }
    public static function inputCity() { return self::$inputCity ?: (self::$inputCity = new InputCityType()); }

    // public static function sight() { return self::$sight ?: (self::$sight = new SightType()); }
    // public static function inputSight() { return self::$inputSight ?: (self::$inputSight = new InputSightType()); }

    public static function place() { return self::$place ?: (self::$place = new PlaceType()); }
    public static function inputPlace() { return self::$inputPlace ?: (self::$inputPlace = new InputPlaceType()); }
    
    public static function answer() { return self::$answer ?: (self::$answer = new AnswerType()); }

    public static function person() { return self::$person ?: (self::$person = new PersonType()); }
    public static function inputPerson() { return self::$inputPerson ?: (self::$inputPerson = new InputPersonType()); }
    
    public static function company() { return self::$company ?: (self::$company = new CompanyType()); }
    public static function inputCompany() { return self::$inputCompany ?: (self::$inputCompany = new InputCompanyType()); }
    
    public static function links() { return self::$links ?: (self::$links = new LinksType()); }
    
    public static function channels() { return self::$channels ?: (self::$channels = new ChannelsType()); }

    public static function landing() { return self::$landing ?: (self::$landing = new LandingType()); }
    public static function landingSegment() { return self::$landingSegment ?: (self::$landingSegment = new LandingSegmentType()); }

    public static function form() { return self::$form ?: (self::$form = new FormType()); }
    public static function formInputs() { return self::$formInputs ?: (self::$formInputs = new FormInputsType()); }
    
    public static function formData() { return self::$formData ?: (self::$formData = new FormDataType()); }
    public static function inputFormData() { return self::$inputFormData ?: (self::$inputFormData = new InputFormDataType()); }

    /*@return \GraphQL\Type\Definition\IntType */
    public static function int()
    {
        return Type::int();
    }

        /*@return \GraphQL\Type\Definition\IdType */
    public static function id()
    {
        return Type::id();
    }

        /*@return \GraphQL\Type\Definition\DateTimeType */
    public static function datetime()
    {
        return Type::string();
    }

    /*@return \GraphQL\Type\Definition\StringType */
    public static function string()
    {
        return Type::string();
    }

    /*@return \GraphQL\Type\Definition\BooleanType */
    public static function boolean()
    {
        return Type::BOOLEAN();
    }


    /*@param \GraphQL\Type\Definition\Type $type
     * @return \GraphQL\Type\Definition\ListOfType */
    public static function listOf($type)
    {
        return Type::listOf($type);
    }

    /*@param \GraphQL\Type\Definition\Type $type
     * @return \GraphQL\Type\Definition\NonNull */
    public static function nonNull($type)
    {
        return Type::nonNull($type);
    }
   
}
?>
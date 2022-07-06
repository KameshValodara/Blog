<?php

namespace App\Http\Controllers\api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{
    Member,
    MemberDetail,
    Company,
    CompanyDetail,
    Post,
    Video,
};

class RelationshipController extends Controller
{

    /**
     * @OA\Get(
     *    path="/api/members-details",
     *    summary="OneToOne (members-membersDetails)",
     *    description="One To One Relationship Members and Member Details",
     *    tags={"Relationship : OneToOne OneToMany ManyToMany"},
     *    @OA\Parameter(
     *      name="id",
     *      in="query",
     *      description="Provide id",
     *      required=true,
     *     ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function membersDetails(Request $request){
        $id=$request->id;
        //---Only show 2nd table data
        //$member_details = Member :: find($id)->member_details;

        //--- Relation using function
        //$member_details = Member::with(['member_details'])->get();
        // $member_details = Member::with(array('member_details'=>function($query){
        //     $query->select('state','member_id');
        // }))->get();

        //--- Relation using in with
        // $member_details = Member::with('member_details:id,state,member_id')->get();

        //--- Has
        //$member_details = Member::has('member_details')->get();
        //return $member_details;

        //--- WhereHas
        $member_details = Member::whereHas('member_details',function ($query){
            $query->where('id','2');
        })->get();
        return $member_details;

    }

    /**
     * @OA\Get(
     *    path="/api/members-company",
     *    summary="OneToMany (members-company)",
     *    description="One To Many Relationship (Members and Company)",
     *    tags={"Relationship : OneToOne OneToMany ManyToMany"},
     *    @OA\Parameter(
     *      name="id",
     *      in="query",
     *      description="Provide id",
     *      required=true,
     *     ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */

    public function membersCompany(Request $request){
        $id=$request->id;
        //$members_companies=Company::find($id)->company;
        //$members_companies=Member::with(['company'])->first();
        $members_companies=Member::find($id)->company;
        return $members_companies;
    }

    /**
     * @OA\Get(
     *    path="/api/company-details",
     *    summary="OneToOne (company-companyDetails)",
     *    description="One To One Relationship Company and Company Details",
     *    tags={"Relationship : OneToOne OneToMany ManyToMany"},
     *    @OA\Parameter(
     *      name="id",
     *      in="query",
     *      description="Provide id",
     *      required=true,
     *     ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */

    public function CompanyDetails(Request $request){
        $id=$request->id;
        $company_details=Company::find($id)->companyDetails;
        return $company_details;
    }

    /**
     * @OA\Post(
     *    path="/api/add-companies",
     *    summary="add-companies",
     *    description="Add Companies",
     *    tags={"Relationship : OneToOne OneToMany ManyToMany"},
     *    @OA\Parameter(
     *      name="name",
     *      in="query",
     *      description="Provide Name",
     *      required=true,
     *     ),
     *    @OA\Parameter(
     *      name="pincode",
     *      in="query",
     *      description="Provide Pincode",
     *      required=true,
     *     ),
     *    @OA\Parameter(
     *      name="member_id",
     *      in="query",
     *      description="Provide Member Id",
     *      required=true,
     *     ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function add_company(Request $request){
        $company = new Company();
        $company->name=$request->name;
        $company->pincode=$request->pincode;
        $company->member_id=$request->member_id;

        $result = $company->save();
        if($result){
            return 'Company added successfully';
        }

    }
    /**
     * @OA\Post(
     *    path="/api/add-members",
     *    summary="add-members",
     *    description="Add Companies",
     *    tags={"Relationship : OneToOne OneToMany ManyToMany"},
     *    @OA\Parameter(
     *      name="name",
     *      in="query",
     *      description="Provide Name",
     *      required=true,
     *     ),
     *    @OA\Parameter(
     *      name="email",
     *      in="query",
     *      description="Provide Email",
     *      required=true,
     *     ),
     *    @OA\Parameter(
     *      name="address",
     *      in="query",
     *      description="Provide Address",
     *      required=true,
     *     ),
     *    @OA\Parameter(
     *      name="company_id",
     *      in="query",
     *      description="Provide Company Ids",
     *      required=true,
     *     ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function add_member(Request $request){
        $member = new Member();
        $member->name = $request->name;
        $member->email = $request->email;
        $member->address = $request->address;
        $result = $member->save();

        //$companies = $request->company_id;
        $companies = [1,2];
        $member->companies()->attach($companies);
        if($result){
            return 'Member added successfully';
        }
    }

    /**
     * @OA\Get(
     *    path="/api/show-companies",
     *    summary="Many To Many Relationship (with Companies)",
     *    description="Show Companies",
     *    tags={"Relationship : OneToOne OneToMany ManyToMany"},
     *    @OA\Parameter(
     *      name="id",
     *      in="query",
     *      description="Provide id",
     *      required=true,
     *     ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function show_companies(Request $request){
        $id = $request->id;
        $companies = Member::find($id)->companies;
        return $companies;
    }

    /**
     * @OA\Get(
     *    path="/api/show-members",
     *    summary="Many To Many Relationship (Members)",
     *    description="Show Members",
     *    tags={"Relationship : OneToOne OneToMany ManyToMany"},
     *    @OA\Parameter(
     *      name="id",
     *      in="query",
     *      description="Provide id",
     *      required=true,
     *     ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function show_members(Request $request){
        $id = $request->id;
        $members = Company::find($id)->members;
        return $members;
    }


    //HasOneThrough
    /**
     * @OA\Get(
     *    path="/api/member-companydetails",
     *    summary="member-companydetails",
     *    description="HasOneThrough between Member to Company Details",
     *    tags={"Relationship : HasOneThrough"},
     *    @OA\Parameter(
     *      name="id",
     *      in="query",
     *      description="Provide id",
     *      required=true,
     *     ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function member_companydetails(Request $request){
        $id=$request->id;
        $company_details = Member::find($id)->member_Tocompany_details;
        return $company_details;
    }

    //hasOneOfMany
    /**
     * @OA\Get(
     *    path="/api/hasOneOfMany",
     *    summary="hasOneOfMany",
     *    description="HasOneOfMany latest, oldest and OfMany",
     *    tags={"Relationship : HasOneThrough"},
     *    @OA\Parameter(
     *      name="id",
     *      in="query",
     *      description="Provide id",
     *      required=true,
     *     ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function latest_oldest_offMany(Request $request){
        $id=$request->id;
        $latestOfMany=Member::find($id)->latest_ofMany;
        $oldestOfMany=Member::find($id)->oldest_ofMany;
        $ofMany=Member::find($id)->ofMany;
        return ['latestOfMany'=>$latestOfMany,'oldestOfMany'=>$oldestOfMany,'ofMany'=>$ofMany];
    }

    //Polymorphic Relationship
    /**
     * @OA\Get(
     *    path="/api/morphOne",
     *    summary="morphOne",
     *    description="Polymorphic morphOne Relationship",
     *    tags={"Relationship : Polymorphic"},
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function morphOne(){
        $post = Post::with('image')->get()->toArray();
        $member = Member::with('image')->get()->toArray();
        return ['post'=>$post,'member'=>$member];
    }

    /**
     * @OA\Get(
     *    path="/api/morphMany",
     *    summary="morphMany",
     *    description="Polymorphic morphMany Relationship",
     *    tags={"Relationship : Polymorphic"},
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function morphMany(){
        $post = Post::with('manyImage')->get()->toArray();
        $member = Member::with('manyImage')->get()->toArray();
        return ['post'=>$post,'member'=>$member];
    }

    /**
     * @OA\Get(
     *    path="/api/morphedByMany",
     *    summary="morphedByMany",
     *    description="Polymorphic Many To Many Relationship",
     *    tags={"Relationship : Polymorphic"},
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *    )
     * ),
     */
    public function morphedByMany(){
        $video = Video::with('tags')->get()->toArray();
        $post = Post::with('tags')->get()->toArray();
        return ['Videos'=>$video,'Posts'=>$post];
    }
}

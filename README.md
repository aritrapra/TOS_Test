@@ SET UP INSTRUCTIONS @@

1. clone this repo

2. open terminal and go the the cloned folder

3. run 'composer install' (It will install all required module)

4. edit .env file on root folder and give mysql database name and connection info

5. run 'php artisan migrate' , (It will create all required database)

6. genarate new key with 'php artisan key:generate' this command

7. run 'php artisan serve' (to serve the application on port 8000)


@@ API INSTRUCTIONS @@

++ all api key session valid for 12 hours
++ every routes have limit of 10 call per minute



** AVAILABLE APIS **

    == REGISTER ==

        url => /api/register
        method  => POST
        permission => any
        perameter => {
            phone =>
                'this field is required '
                'need to be minimum 10 digit and numeric'

            'email' => 
                'this field is required '
                'need to be a valid email address'
            
            'password' => 
                'this field is required '
                'need to be minimum 8 digit in length'

            'confirm_password' => 
                'this field is required '
                'same as password'

        }

        responce (success) => {
            "error": false,
            "message": "User Registered",
            "data": {
                "token": "764c87ca8fe824e94858018edd69510dfa0f427aa4a4c7ab5ea89049be3d539e"
            }
        }

    == LOGIN ==
        url => /api/login
            method  => POST
            permission => any
            perameter => {
                phone =>
                    'need to be minimum 10 digit and numeric'
                OR
                'email' => 
                    'need to be a valid email address'
                
                'password' => 
                    'this field is required '
                    'need to be minimum 8 digit in length'
            }

            responce (success) => {
                "error": false,
                "message": "Logged In",
                "data": {
                    "token": "c326c53eca383148a823730da4d749294e5e3d105decceb451250198fe6336c6"
                }
            }

    == PROFILE ==

        url => /api/profile
            method  => GET
            permission => any
            perameter => {
                token =>
                    'this field is required '
                    'need to be a alpha numeric string'
            }

        responce (success) => {
            "error": false,
            "data": {
                "email": "a@g.ca",
                "phone number": "9999999990",
                "first name": null,
                "last name": null,
                "role": "editor"
            }
        }

    == UPDATE PROFILE

        url => /api/profile/update
            method  => POST
            permission => any
            perameter => {
                token =>
                    'this field is required '
                    'need to be a alpha numeric string'

                first_name (optional) =>
                    'min 2 digit and maximux 60 digit'
                    'need to be a alpha numeric string'

                last_name (optional) =>
                    'min 2 digit and maximux 60 digit'
                    'need to be a alpha numeric string'

                role (optional) =>
                    'role can be editor or writer'
            }

        responce (success) => {
            "error": false,
            "message": "profile updated"
        }


    == CREATE NEW ARTICLE ==
        url => /api/article/create
            method  => POST
            permission => writer
            perameter => {
                token =>
                    'this field is required '
                    'need to be a alpha numeric string'

                title =>
                    'this field is required '
                    'min 4 digit and maximux 100 digit'
                    'need to be a valid string'

                post => 
                    'this field is required '
                    'min 4 digit and maximux 4000 digit'
                    'need to be a valid string'
            }

        responce (success) => {
            "error": false,
            "id": "56f54f8de2f8968472d1e5a1c06cba3760132dea79b1414f826fd1e0806adb19",
            "message": "article posted"
        }


    == GET ARTICLE == 

        url => /api/article
            method  => GET
            permission => writer and article owner
            perameter => {
                token =>
                    'this field is required '
                    'need to be a alpha numeric string'

                id =>
                    'this field is required '
                    'need to be a alpha numeric string'
                    'need to be a valid article id'
            }

        responce (success) => {
            "error": true,
            "data": {
                "title": "its post title",
                "post": "its the post"
            }
        }

    == UPDATE ARTICLE

        url => /api/article/update
            method  => POST
            permission => writer and article owner
            perameter => {
                token =>
                    'this field is required '
                    'need to be a alpha numeric string'

                id =>
                    'this field is required '
                    'need to be a alpha numeric string'
                    'need to be a valid article id'
                
                title (optional) =>
                    'min 4 digit and maximux 100 digit'

                post (optional)=>
                    'min 4 digit and maximux 4000 digit'
            }

        responce (success) => {
            "error": false,
            "message": "post updated"
        }

    == DELETE ARTICLE ==

        url => /api/article/delete
            method  => POST
            permission => writer and article owner
            perameter => {
                token =>
                    'this field is required '
                    'need to be a alpha numeric string'

                id =>
                    'this field is required '
                    'need to be a alpha numeric string'
                    'need to be a valid article id'
            }

        responce (success) => {
            "error": false,
            "message": "post deleted"
        }


    == ARTICLE COMMENTS ==

        url => /api/article/comments
            method  => POST
            permission => writer and article owner
            perameter => {
                token =>
                    'this field is required '
                    'need to be a alpha numeric string'

                id =>
                    'this field is required '
                    'need to be a alpha numeric string'
                    'need to be a valid article id'
                
                page (optional and default 0) => 
                    'this must be a number'
            }

        responce (success) => {
            "error": false,
            "data": {
                "current_page": 1,
                "data": [
                    {
                        "id": "7dbd4da8ef058b97f3fe55111aa59aa87e8a7f8d9edb6308156549e2b83f9792",
                        "article_id": "f00662861d15b75858a6c4d5f1b2a5b18bf6a66c14277dd0ff6fc4f156c4d29c",
                        "comment": "Its comment",
                        "post_by": "f5cc8b6e569fc1a7f15a2933fc071e1812c3fb54e10a56a24b5e77a7a4c7a10e",
                        "delete": 0,
                        "created_at": "2023-07-20T05:05:38.000000Z",
                        "updated_at": "2023-07-20T05:05:38.000000Z"
                    },
                    {
                        "id": "952aa849600cd0efefa5958a1eb2cf3ef65c4a9e7f3e25b6cfceea180155db3a",
                        "article_id": "f00662861d15b75858a6c4d5f1b2a5b18bf6a66c14277dd0ff6fc4f156c4d29c",
                        "comment": "Its commenta",
                        "post_by": "f5cc8b6e569fc1a7f15a2933fc071e1812c3fb54e10a56a24b5e77a7a4c7a10e",
                        "delete": 0,
                        "created_at": "2023-07-20T05:05:58.000000Z",
                        "updated_at": "2023-07-20T05:05:58.000000Z"
                    },
                    {
                        "id": "3f08f902e957038dc3f991544ca9401ce8e630e863644cdddd8196acc3e287fd",
                        "article_id": "f00662861d15b75858a6c4d5f1b2a5b18bf6a66c14277dd0ff6fc4f156c4d29c",
                        "comment": "Its commenta a",
                        "post_by": "f5cc8b6e569fc1a7f15a2933fc071e1812c3fb54e10a56a24b5e77a7a4c7a10e",
                        "delete": 0,
                        "created_at": "2023-07-20T05:06:02.000000Z",
                        "updated_at": "2023-07-20T05:06:02.000000Z"
                    }
                ],
                "first_page_url": "http://127.0.0.1:8000/api/article/comments?page=1",
                "from": 1,
                "last_page": 1,
                "last_page_url": "http://127.0.0.1:8000/api/article/comments?page=1",
                "links": [
                    {
                        "url": null,
                        "label": "&laquo; Previous",
                        "active": false
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/article/comments?page=1",
                        "label": "1",
                        "active": true
                    },
                    {
                        "url": null,
                        "label": "Next &raquo;",
                        "active": false
                    }
                ],
                "next_page_url": null,
                "path": "http://127.0.0.1:8000/api/article/comments",
                "per_page": 20,
                "prev_page_url": null,
                "to": 3,
                "total": 3
            }
        }

    == ALL ARTICLE ==

        url => /api/article/all
            method  => POST
            permission => editor
            perameter => {
                token =>
                    'this field is required '
                    'need to be a alpha numeric string'

                page (optional and default 0) =>
                    'need to be a number'
            }

        responce (success) => {
            "error": false,
            "data": {
                "current_page": 1,
                "data": [
                    {
                        "id": "f00662861d15b75858a6c4d5f1b2a5b18bf6a66c14277dd0ff6fc4f156c4d29c",
                        "title": "its post title updated",
                        "post": "its the post updated",
                        "delete": 0,
                        "created_at": "2023-07-20T04:55:38.000000Z",
                        "updated_at": "2023-07-20T04:55:38.000000Z"
                    },
                    {
                        "id": "8b175ea07768beabfbe3cf610aef0a3ab623f443011433c2fc3131adbf4d4f27",
                        "title": "its post title updateda",
                        "post": "its the post updated a",
                        "delete": 0,
                        "created_at": "2023-07-20T04:55:44.000000Z",
                        "updated_at": "2023-07-20T04:55:44.000000Z"
                    }
                ],
                "first_page_url": "http://127.0.0.1:8000/api/article/all?page=1",
                "from": 1,
                "last_page": 1,
                "last_page_url": "http://127.0.0.1:8000/api/article/all?page=1",
                "links": [
                    {
                        "url": null,
                        "label": "&laquo; Previous",
                        "active": false
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/article/all?page=1",
                        "label": "1",
                        "active": true
                    },
                    {
                        "url": null,
                        "label": "Next &raquo;",
                        "active": false
                    }
                ],
                "next_page_url": null,
                "path": "http://127.0.0.1:8000/api/article/all",
                "per_page": 20,
                "prev_page_url": null,
                "to": 2,
                "total": 2
            }
        }


    == CREATE COMMENT ==

        url => /api/article/comment/create
            method  => POST
            permission => editor
            perameter => {
                token =>
                    'this field is required '
                    'need to be a alpha numeric string'

                id =>
                    'this field is required '
                    'need to be a alpha numeric string'
                    'need to be a valid article id'
                
                comment => 
                    'this field is required '
                    'min 4 digit and maximux 100 digit'
            }

            responce (success) => {
                "error": false,
                "message": "comment sucessfully posted"
            }








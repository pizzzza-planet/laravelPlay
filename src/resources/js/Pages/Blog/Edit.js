import React from "react";
import Authenticated from "@/Layouts/Authenticated";
import { Head, useForm } from "@inertiajs/inertia-react";
import Input from "@/Components/Input";
import Label from "@/Components/Label";
import Button from "@/Components/Button";
import ValidationErrors from "@/Components/ValidationErrors";

export default function Edit(props) {
    const { data, setData, patch, processing, errors } = useForm({
        title: props.blog.title,
        content: props.blog.content,
        category_name: props.blog.category.category_name,
    });

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();

        patch(route(`${props.target}.blog.update`, props.blog.id));
    };

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            target={props.target}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Blog
                </h2>
            }
        >
            <Head title="Blog Edit" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-blue-600 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-blue-600 border-b border-blue-900">
                            <ValidationErrors errors={errors} />
                            <form onSubmit={submit}>
                                <div>
                                    <Label forInput="title" value="Title" />

                                    <Input
                                        type="text"
                                        name="title"
                                        value={data.title}
                                        className="mt-1 block w-full"
                                        isFocused={true}
                                        handleChange={onHandleChange}
                                    />
                                </div>
                                <div>
                                    <Label forInput="content" value="Content" />

                                    <Input
                                        type="text"
                                        name="content"
                                        value={data.content}
                                        className="mt-1 block w-full"
                                        handleChange={onHandleChange}
                                    />
                                </div>
                                <div>
                                    <Label
                                        forInput="category_name"
                                        value="Category"
                                    />

                                    <Input
                                        type="text"
                                        name="category_name"
                                        value={data.category_name}
                                        className="mt-1 block w-full"
                                        isFocused={true}
                                        handleChange={onHandleChange}
                                    />
                                </div>
                                <div className="flex items-center justify-end mt-4">
                                    <Button
                                        className="ml-4"
                                        processing={processing}
                                    >
                                        更新
                                    </Button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}

import React from "react";
import { Link, Head } from "@inertiajs/inertia-react";

export default function Welcome(props) {
    return (
        <>
            <Head title="Welcome" />
            <div className="relative flex items-top justify-center min-h-screen bg-blue-800 sm:items-center sm:pt-0">
                <div className="font-semibold text-2xl text-blue-200">
                    {props.target === "user" ? "Welcome" : "Welcome Admin"}
                </div>
                <div className="fixed top-0 px-6 py-4 sm:block">
                    {props.auth.user ? (
                        <Link
                            href={route("mypage")}
                            className="text-sm text-white underline"
                        >
                            MyPage
                        </Link>
                    ) : (
                        <>
                            <Link
                                href={route(`${props.target}.login`)}
                                className="text-sm text-white underline"
                            >
                                Log in
                            </Link>

                            <Link
                                href={route(`${props.target}.register`)}
                                className="ml-4 text-sm text-white underline"
                            >
                                Register
                            </Link>
                        </>
                    )}
                </div>
            </div>
        </>
    );
}
